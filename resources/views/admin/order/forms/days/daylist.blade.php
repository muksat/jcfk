@extends('admin.layout')

@section('side-nav', false)
@section('page-wrapper', false)
@section('pageHeading')
    {{ $orderForm->school_name }} [{{ $orderForm->name }}]
@stop

@section('content')
    <div id="dayList">
        <div class="row">
            <div class="col-md-12">
                <button v-on="click: publishOrderForm" class="btn btn-success pull-right">Publish</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input v-model="token" type="hidden" name="_token" value="{{ csrf_token() }}">
                <input v-model="orderFormId" type="hidden" name="order_form_id" value="{{ $orderForm->order_form_id }}">
                <day v-repeat="day in days" token="@{{@ token }}"></day>
            </div>
        </div>
    </div>
@stop

