<?php

namespace Jcfk\Http\Controllers\Admin;

use Carbon\Carbon;
use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Collective\Annotations\Routing\Annotations\Annotations\Put;
use Illuminate\Http\Request;
use Jcfk\Http\Controllers\Controller;
use Jcfk\Models\OrderForm;
use Jcfk\Validators\OrderFormValidator;

/**
 * @Middleware("admin")
 */
class OrderFormController extends Controller
{
    /**
     * @var OrderForm
     */
    private $orderForm;

    public function __construct(OrderForm $orderForm)
    {
        $this->orderForm = $orderForm;
    }

    /**
     * @Get("/admin/order-forms", as="admin::orderForms")
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.order.forms.index');
    }

    /**
     * @Get("/admin/order-forms/list", as="admin::orderForms.list")
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getList()
    {
        $schools = $this->orderForm->paginate(25)
            ->toArray();

        $schools['columns'] = ['name', 'school_name'];
        $schools['pk']      = ['order_form_id'];

        return $schools;
    }

    /**
     * @Get("/admin/order-forms/{orderFormId}", as="admin::orderForm.show", where={"orderFormId": "[0-9]+"}))
     *
     * @param $orderFormId
     * @return mixed
     */
    public function show($orderFormId)
    {
        return $this->orderForm->find($orderFormId)
            ->toFormDataArray();
    }

    /**
     * @Put("/admin/order-forms", as="admin::orderForm.store")
     *
     * @param Request $request
     * @return OrderForm
     */
    public function store(Request $request, OrderFormValidator $orderFormValidator)
    {
        $this->validate($request, $orderFormValidator);

        $orderFormId = $request->get('order_form_id');
        $input    = $request->all();

        /** @var OrderForm $school */
        $orderForm = $this->orderForm->findOrNew($orderFormId);

        $orderForm->fill([
            'school_id'  => $request->get('school_id'),
            'start_date' => Carbon::createFromFormat('m/d/Y', $request->get('start_date')),
            'end_date'   => Carbon::createFromFormat('m/d/Y', $request->get('end_date'))
        ]);

        $orderForm->save();

        return $orderForm;
    }

    /**
     * @Get("/admin/order-forms/delete/{orderFormId}", as="admin::orderForm.delete")
     *
     * @param $orderFormId
     */
    public function delete($orderFormId)
    {
        return (string) $this->orderForm->destroy($orderFormId);
    }

    /**
     * @Get("/admin/order-forms/publish/{orderFormId}", as="admin::orderForm.publish")
     *
     * @param $orderFormId
     */
    public function publish($orderFormId)
    {
        /** @var OrderForm $orderForm */
        $orderForm = $this->orderForm->find($orderFormId);

        $orderForm->publish();

        return response()->json();
    }
}
