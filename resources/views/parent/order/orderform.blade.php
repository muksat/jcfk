@extends('parent.layout')

@section('pageHeading')
    Order
@stop

@section('content')
    <div id="orderForm">
        <input v-model="token" type="hidden" name="_token" value="{{ csrf_token() }}">
        <div v-show="!orderFormId">
            <div class="row">
                <div class="col-md-12">
                    <button v-on="click: checkout" class="btn btn-success pull-right">Checkout ($@{{ submittedForms | totalPrice }})</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Student</th>
                            <th>Order form</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-repeat="submittedForm in submittedForms">
                            <td> @{{ getStudentById(submittedForm.studentId).name }}</td>
                            <td> @{{ getOrderFormById(submittedForm.orderFormId).name }}</td>
                            <td> $@{{ submittedForm.totalPrice }} CAD</td>
                            <td>
                                <button class="btn btn-danger btn-sm" v-on="click: removeSubmittedForm($index)">Delete
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div v-show="students | availableStudents | length" class="row">
                <div class="col-md-12">
                    <div class="control-group">
                        <label class="control-label" for="student">Pick a student</label>

                        <div class="controls">
                            <select v-model="student" name="student" id="studentSelect"
                                    options="students | availableStudents | selectify 'name' 'student_id'"></select>
                            </select>
                        </div>
                    </div>
                    <div v-show="student" class="control-group">
                        <label class="control-label" for="orderFormId">Pick an order form</label>

                        <div class="controls">
                            <select v-model="orderFormId" name="orderFormId" id="orderFormId"
                                    options="orderForms | availableForms student | selectify 'name' 'order_form_id'">></select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <order-day-list v-show="orderFormId" order-form-id="@{{@ orderFormId }}" add-to-cart="@{{ addToCart }}"></order-day-list>
    </div>
@stop

