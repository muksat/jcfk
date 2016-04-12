<?php

namespace Jcfk\Http\Controllers\Admin;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Collective\Annotations\Routing\Annotations\Annotations\Put;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Jcfk\Http\Controllers\Controller;
use Jcfk\Models\Meal;

/**
 * @Middleware("admin")
 */
class MealController extends Controller
{
    /**
     * @var Meal
     */
    private $meal;

    public function __construct(Meal $meal)
    {
        $this->meal = $meal;
    }

    /**
     * @Get("/admin/meal", as="admin::meal.index")
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.meal.index');
    }

    /**
     * @Get("/admin/meal/list", as="admin::meal.list")
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getList()
    {
        $meals = $this->meal->paginate(30)
            ->toArray();

        $meals['columns'] = ['meal_name', 'description'];
        $meals['pk']      = ['meal_id'];

        return $meals;
    }

    /**
     * @Get("/admin/meal/{mealId}", as="admin::meal.show")
     *
     * @param $mealId
     * @return mixed
     */
    public function show($mealId)
    {
        return $this->meal->find($mealId);
    }

    /**
     * @Put("/admin/meal", as="admin::meal.store")
     *
     * @param Request $request
     * @return Meal
     */
    public function store(Request $request)
    {
        $mealId = $request->get('meal_id');
        $input    = $request->all();

        /** @var meal $meal */
        $meal = $this->meal->findOrNew($mealId);

        $meal->fill($input);
        $meal->save();

        return $meal;
    }

    /**
     * @Get("/admin/meal/delete/{mealId}", as="admin::meal.delete")
     *
     * @param $mealId
     */
    public function delete($mealId)
    {
        return (string) $this->meal->destroy($mealId);
    }

    /**
     * @Get("/admin/meal/search/{mealName}", as="admin::meal.search")
     *
     * @return JsonResponse
     */
    public function search($schoolName)
    {
        return $this->meal->searchByName($schoolName);
    }
}
