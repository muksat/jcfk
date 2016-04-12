@extends('blank')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background:#eea236; color: white;">Login</div>
                    <div class="row">
                        &nbsp;
                        <div class="col-md-10">
                            <span class="error">
                                {{ $errors->first('email') }}
                            </span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('auth') }}" class="form-horizontal"
                          style="padding: 0px 20px 0px 20px;">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label class="col-md-3 control-label ">E-Mail</label>
                            <div class="col-md-7">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Password</label>

                            <div class="col-md-7">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-sm-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" class="pull-left remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-5">
                                <button type="submit" class="btn btn-warning">Login</button>
                                {{--<a href="{{ url('/password/email') }}">Forgot Password ?</a>--}}
                                {{--<a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your--}}
                                {{--Password?</a>--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background:#eea236; color: white;">
                        Registration
                    </div>
                    <div class="panel-body">
                        <div id="login_text">
                            Providing your children with healthy, well balanced, and nutritious
                            lunches can be difficult for today's parent. Having your child enjoy
                            that lunch can be even harder. We get children excited about school
                            lunches again, by delivering hot, homemade lunches right to their
                            classrooms. Not only are parents relieved of the daunting task of preparing lunch, but they
                            can also rest assured that their child is being is
                            receiving a well balanced, nutritious, trans-fat free meal.
                        </div>
                        <div class="col-md-6 col-md-offset-0">
                            <a class="btn btn-warning" href="{{ route('register') }}">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop