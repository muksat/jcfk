<?php

namespace Jcfk\Http\Controllers\Parent;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Collective\Annotations\Routing\Annotations\Annotations\Put;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Jcfk\Http\Controllers\Controller;
use Jcfk\Models\OrderForm;
use Jcfk\Models\Student;
use Jcfk\Order\Form\DayList;
use Jcfk\Order\ShoppingCart;

/**
 * @Middleware("parent")
 */
class OrderController extends Controller
{
    /**
     * @var OrderForm
     */
    private $orderForm;

    /**
     * @var Guard
     */
    private $auth;

    /**
     * @var DayList
     */
    private $dayList;

    public function __construct(OrderForm $orderForm, Guard $auth, DayList $dayList)
    {
        $this->orderForm = $orderForm;
        $this->auth      = $auth;
        $this->dayList   = $dayList;
    }

    /**
     * @Get("/parent/order-forms", as="parent::order")
     *
     * @param $orderFormId
     */
    public function getForm()
    {
        return view('parent.order.orderform');
    }

    /**
     * @Get("/parent/order-forms/load", as="parent::order.loadData")
     */
    public function initialLoad(Student $student, ShoppingCart $cart)
    {
        /** @var Collection $students */
        $students = $student->getStudentsWithShcool($this->auth->user());

        $schoolIds = array_unique($students->lists('school_id')->toArray());

        $availableOrderForms = $this->orderForm->whereIn('school_id', $schoolIds)
            ->where('is_published', '=', 1)
            ->get();

        $availableOrderForms->load('school');

        return response()
            ->json([
                'students'   => $students->toArray(),
                'orderForms' => $availableOrderForms->toArray(),
                'cart'       => $cart->getCart()
            ]);
    }

    /**
     * @Get("/parent/order-forms/days/{orderFormId}", as="parent::order.formDays")
     */
    public function days($orderFormId)
    {
        return $this->dayList->getDayList($orderFormId);
    }

    /**
     * @Put("/parent/order-forms/add-to-cart", as="parent::order.addToCart")
     */
    public function addToCart(Request $request, ShoppingCart $cart)
    {
        $cart->addToCart($request->get('item'));
    }

    /**
     * @Post("/parent/order-forms/remove-from-cart", as="parent::order.addToCart")
     */
    public function removeFromCart(Request $request, ShoppingCart $cart)
    {
        $cart->removeFromCart($request->get('item'));
    }
}
