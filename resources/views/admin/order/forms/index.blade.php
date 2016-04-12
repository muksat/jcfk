@extends('admin.layout')

@section('content')
    <div id="orderForms">
        <div class="row">
            <div class="col-md-12">
                <button v-on="click: passwordChange = true" type="button" class="btn btn-info  pull-right" data-toggle="modal"
                        data-target="#parentForm">Add order form
                </button>
            </div>
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-md-12">
                <grid actions="@{{ orderFormActions }}" row-actions="@{{ showRowActions  }}" url="@{{ $options.url }}"></grid>
            </div>
        </div>
        @include('admin.order.forms.form')
    </div>
@stop