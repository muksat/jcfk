@extends('admin.layout')

@section('content')
    <div id="teacher">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-info  pull-right" data-toggle="modal"   data-target="#teacherForm">Add teacher
                </button>
            </div>
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-md-12">
                <grid id="teachers" url="@{{ $options.url }}"></grid>
            </div>
        </div>
        @include('admin.teacher.form')
    </div>
@stop