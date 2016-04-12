@extends('admin.layout')

@section('content')
    <div id="parent">
        <div class="row">
            <div class="col-md-12">
                <button v-on="click: passwordChange = true" type="button" class="btn btn-info  pull-right" data-toggle="modal"
                        data-target="#parentForm">Add parent
                </button>
            </div>
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-md-12">
                <grid id="parents" url="@{{ $options.url }}"></grid>
            </div>
        </div>
        @include('admin.parent.form')
    </div>
@stop