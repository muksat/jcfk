<?php

namespace Jcfk\Http\Controllers\Parent;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Illuminate\Http\Request;
use Jcfk\Http\Controllers\Controller;
use Jcfk\Models\Order;
use Jcfk\Models\OrderStatus;
use Jcfk\Models\PaymentMethod;
use Jcfk\Order\ShoppingCart;
use Moneris_Gateway;

/**
 * @Middleware("parent")
 */
class CheckoutController extends Controller
{
    /**
     * @var ShoppingCart
     */
    private $cart;

    /**
     * @var Order
     */
    private $order;

    public function __construct(ShoppingCart $cart, Order $order)
    {
        $this->cart  = $cart;
        $this->order = $order;
    }

    /**
     * @Get("/parent/checkout", as="parent::checkout")
     */
    public function checkoutForm(PaymentMethod $paymentMethod)
    {
        if ($this->cart->isEmpty()) {
            //ADD A MESSAGE VARIABLE TO DISPLAY ON THE ORDER PAGE
            //something like "Your cart has expired..."
            return response()->redirectToRoute('parent::order');
        }

        if ($this->cart->isEmpty()) {
            return response()->redirectToRoute('parent::order');
        }

        return view('parent.checkout.checkout')
            ->with('cart', $this->cart)
            ->with('paymentMethods', $paymentMethod->get());
    }

    /**
     * @Post("/parent/checkout/creditcard", as="parent::checkout.creditcard")
     */
    public function creditCardCheckout(Moneris_Gateway $moneris, Request $request)
    {
        if ($this->cart->isEmpty()) {
            //TODO: ADD A MESSAGE VARIABLE TO DISPLAY ON THE ORDER PAGE
            //something like "Your cart has expired..."
            return response()->redirectToRoute('parent::order');
        }

        $paymentParams = $request->except('_token');

        $order = Order::createOrderWithAmount($this->cart->getTotalWithTax(), PaymentMethod::CREDIT_CARD);

        $paymentParams['order_id'] = $order->getOrderUuid();
        $paymentParams['amount']   = $this->cart->getTotalWithTax();

        $monerisResponse = $moneris->purchase($paymentParams);

        if (!$monerisResponse->was_successful()) {
            $order->setOrderStatusId(OrderStatus::FAILED);
            $order->save();

            //TODO: add variables to the view, display failed receipt. create the view file
            return view('parent.checkout.creditcard.failed');
        }

        $order->setOrderStatusId(OrderStatus::SUCCESSFUL);
        $order->save();

        //TODO: add variables to the view, display successful receipt, create the view file
        return view('parent.checkout.creditcard.successful');
    }

    /**
     * @Post("/parent/checkout/cash", as="parent::checkout.cash")
     */
    public function cashCheckout()
    {
        if ($this->cart->isEmpty()) {
            //TODO: ADD A MESSAGE VARIABLE TO DISPLAY ON THE ORDER PAGE
            //something like "Your cart has expired..."
            return response()->redirectToRoute('parent::order');
        }

        $order = Order::createOrderWithAmount($this->cart->getTotalWithTax(), PaymentMethod::CASH);
        $order->setOrderStatusId(OrderStatus::PENDING);

        //TODO: add variables to the view, display successful receipt, create the view file
        return view('parent.checkout.cash.successful');
    }
}