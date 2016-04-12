@extends('admin.layout')

@section('content')
    <div id="meal">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-info pull-right" data-toggle="modal"   data-target="#mealForm">Add meal
                </button>
            </div>
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-md-12">
                <grid id="meals" url="@{{ $options.url }}"></grid>
            </div>
        </div>
        @include('admin.meal.form')
    </div>
@stop