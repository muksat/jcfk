@extends('parent.layout')

@section('content')
    <div id="checkoutForm">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Student</th>
                        <th>Order form</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cart->items() as $item)
                        <tr>
                            <td> {{ $item['studentName'] }}</td>
                            <td> {{ $item['orderFormName'] }}</td>
                            <td> ${{ $item['totalPrice'] }} CAD</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{-- TODO: style the totals --}}
                <div class="pull-right">Subtotal: ${{ $cart->getTotal() }} CAD</div>
                <div class="pull-right">Tax: ${{ $cart->getTax() }} CAD</div>
                <div class="pull-right">Total: ${{ $cart->getTotalWithTax() }} CAD</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="controls">
                    <select v-model="paymentMethod" name="paymentMethod" id="paymentMethod">
                        @foreach($paymentMethods as $paymentMethod)
                            <option value="{{ $paymentMethod->getPaymentMethodId() }}">{{ $paymentMethod->getPaymentMethod() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{-- TODO: STYLE THE FORMS, cash checkout form is only a button --}}
                <form v-show="paymentMethod == 2" action="{{ route('parent::checkout.cash') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit">
                </form>
                <form v-show="paymentMethod == 1" action="{{ route('parent::checkout.creditcard') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text" name="cc_number" value="">
                    <input type="text" name="expiry_month" value="">
                    <input type="text" name="expiry_year" value="">
                    <input type="submit">
                </form>
            </div>
        </div>
    </div>
@stop