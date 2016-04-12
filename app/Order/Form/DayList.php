<?php

namespace Jcfk\Order\Form;

use Carbon\Carbon;
use Jcfk\Models\OrderForm;

class DayList
{
    /**
     * @var OrderForm
     */
    private $orderForm;

    public function __construct(OrderForm $orderForm)
    {

        $this->orderForm = $orderForm;
    }

    public function createOrderList($orderFormId)
    {
        /** @var OrderForm $orderForm */
        $orderForm = $this->orderForm->with('menuItems', 'menuItems.meal', 'school')
            ->find($orderFormId);

        $days = $this->createDaysArray($orderForm);

        return $this->formatExistingDays($orderForm, $days);
    }


    public function getDayList($orderFormId)
    {
        /** @var OrderForm $orderForm */
        $orderForm = $this->orderForm->with('menuItems', 'menuItems.meal', 'school')
            ->find($orderFormId);

        return [
            'days'  => $this->formatExistingDays($orderForm, []),
            'meal_price' => $orderForm->school->meal_price
        ];
    }

    /**
     * @param OrderForm $orderForm
     * @return array
     */
    private function formatExistingDays(OrderForm $orderForm, array $days)
    {
        foreach ($orderForm->menuItems as $menuItem) {
            if (!array_key_exists($this->dateToArrayKey($menuItem->date), $days)) {
                $days[$this->dateToArrayKey($menuItem->date)] = $this->createDay($menuItem->date, $orderForm);
            }

            $days[$this->dateToArrayKey($menuItem->date)]['meals'][] = $menuItem->meal->toArray();
        }

        return array_values($days);
    }

    /**
     * @param OrderForm $orderForm
     * @param array $days
     * @return array
     */
    private function createDaysArray(OrderForm $orderForm)
    {
        /** @var Carbon $date */
        $date = $orderForm->start_date;

        $days = [];

        while ($date->lte($orderForm->end_date)) {

            if ($date->isWeekend()) {
                $date->addDay();
                continue;
            }

            $days[$this->dateToArrayKey($date)] = $this->createDay($date, $orderForm);

            $date->addDay();
        }

        return $days;
    }

    /**
     * @param Carbon $date
     * @return string
     */
    private function dateToArrayKey(Carbon $date)
    {
        return $date->format('m/d/Y');
    }

    private function createDay(Carbon $date, OrderForm $orderForm)
    {
        return [
            'date'          => $date->format('d-M-y [D]'),
            'short_date'    => $date->format('dmyy'),
            'order_form_id' => $orderForm->order_form_id,
            'meals'         => []
        ];
    }
}
