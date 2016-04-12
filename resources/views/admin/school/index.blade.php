@extends('admin.layout')

@section('content')
    <div id="school">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-info  pull-right" data-toggle="modal"
                        data-target="#schoolForm">Add school
                </button>
            </div>

        </div>
         <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-md-12">
                <grid id="schools" url="@{{ $options.url }}"></grid>
            </div>
        </div>
        @include('admin.school.form')
    </div>
@stop