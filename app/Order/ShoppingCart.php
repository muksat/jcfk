<?php

namespace Jcfk\Order;

use Illuminate\Auth\Guard;
use Illuminate\Support\Collection;
use Jcfk\Models\OrderForm;
use Jcfk\Models\Student;

class ShoppingCart
{
    const TAX_RATE = 13;

    /**
     * @var Guard
     */
    private $auth;

    /**
     * @var Student
     */
    private $student;

    /**
     * @var OrderForm
     */
    private $orderForm;

    /**
     * @param Guard $auth
     * @param Student $student
     * @param OrderForm $orderForm
     */
    public function __construct(Guard $auth, Student $student, OrderForm $orderForm)
    {
        $this->auth      = $auth;
        $this->student   = $student;
        $this->orderForm = $orderForm;
    }

    public function getCart()
    {
        return array_values(\Cache::get($this->cartKey(), []));
    }

    public function items()
    {
        $items = $this->getCart();

        /** @var \Illuminate\Database\Eloquent\Collection $students */
        $students = $this->student->getStudentsByIds(array_column($items, 'studentId'));

        /** @var \Illuminate\Database\Eloquent\Collection $orderForms */
        $orderForms = $this->orderForm->getFormsByIds(array_column($items, 'orderFormId'));

        foreach ($items as &$item) {
            $item['studentName']   = $students->find($item['studentId'])->name;
            $item['orderFormName'] = $orderForms->find($item['orderFormId'])->name;
        }

        return $items;
    }

    public function addToCart($item)
    {
        $cart = [];

        if (\Cache::has($this->cartKey())) {
            $cart = $this->getCart();
        }

        $cart[] = $item;

        \Cache::put($this->cartKey(), $cart, 60);
    }

    public function removeFromCart($item)
    {
        if (!\Cache::has($this->cartKey())) {
            return;
        }

        $cart = $this->getCart();

        foreach ($cart as $key => $cartItem) {
            if (!$this->sameItem($item, $cartItem)) {
                continue;
            }

            unset($cart[$key]);

            \Cache::put($this->cartKey(), $cart, 60);

            break;
        }
    }

    private function cartKey()
    {
        return sprintf('%s_user_cart', $this->auth->user()->user_id);
    }

    private function sameItem($item, $cartItem)
    {
        return $item == $cartItem;
    }

    public function isEmpty()
    {
        return (bool) !$this->getCart();
    }

    public function getTotal()
    {
        return array_sum(array_column($this->getCart(), 'totalPrice'));
    }

    public function getTax()
    {
        return $this->getTotal() * (self::TAX_RATE / 100);
    }

    public function getTotalWithTax()
    {
        return $this->getTotal() + $this->getTax();
    }
}