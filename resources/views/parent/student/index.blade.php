@extends('parent.layout')

@section('content')
    <div id="student">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-info  pull-right" data-toggle="modal"
                        data-target="#studentForm">Add student
                </button>
            </div>
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-md-12">
                <grid id="students" no-actions="true" url="@{{ $options.url }}"></grid>
            </div>
        </div>
        @include('parent.student.form')
    </div>
@stop