@extends('admin.layout')

@section('content')
    <div id="user">
        <div class="row">
            <div class="col-md-12">
                <button v-on="click: passwordChange = true" type="button" class="btn btn-info pull-right" data-toggle="modal"
                        data-target="#userForm">Add user
                </button>
            </div>
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-md-12">
                <grid id="users" url="@{{ $options.url }}"></grid>
            </div>
        </div>
        @include('admin.user.form')
    </div>
@stop