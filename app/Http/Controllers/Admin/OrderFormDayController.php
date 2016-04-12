<?php

namespace Jcfk\Http\Controllers\Admin;

use Carbon\Carbon;
use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Collective\Annotations\Routing\Annotations\Annotations\Put;
use Illuminate\Http\Request;
use Jcfk\Http\Controllers\Controller;
use Jcfk\Models\MenuItem;
use Jcfk\Models\OrderForm;
use Jcfk\Order\Form\DayList;

/**
 * @Middleware("admin")
 */
class OrderFormDayController extends Controller
{
    /**
     * @var OrderForm
     */
    private $orderForm;
    /**
     * @var DayList
     */
    private $dayList;

    public function __construct(OrderForm $orderForm, DayList $dayList)
    {
        $this->orderForm = $orderForm;
        $this->dayList   = $dayList;
    }

    /**
     * @Get("/admin/order-forms/days/{orderFormId}", as="admin.orderForm.days")
     * @param $orderFromId
     */
    public function index($orderFormId)
    {
        $orderForm = $this->orderForm->find($orderFormId);

        return view('admin.order.forms.days.daylist')
            ->with('orderForm', $orderForm);
    }

    /**
     * @Get("/admin/order-forms/days/list/{orderFormId}", as="admin.orderForm.days.list")
     * @param $orderFromId
     */
    public function show($orderFromId)
    {
        return $this->dayList->createOrderList($orderFromId);
    }

    /**
     * @Put("/admin/order-forms/days", as="admin.orderForm.days.addMeal")
     */
    public function addMeal(Request $request)
    {
        $menuItem = new MenuItem();

        $menuItem->date          = Carbon::createFromFormat('dmyy', $request->get('date'));
        $menuItem->order_form_id = $request->get('order_form_id');
        $menuItem->meal_id       = $request->get('meal_id');

        $menuItem->save();

        $menuItem->load('meal');

        return $menuItem->meal;
    }

    /**
     * @Post("/admin/order-forms/days", as="admin.orderForm.days.deleteMeal")
     */
    public function deleteMeal(Request $request, MenuItem $menuItem)
    {
        $menuItem->where('date', '=', Carbon::createFromFormat('dmyy', $request->get('date'))->toDateString())
            ->where('order_form_id', '=', $request->get('order_form_id'))
            ->where('meal_id', '=', $request->get('meal_id'))
            ->delete();

        return response()->json();
    }
}
