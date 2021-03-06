

@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login via Passport</div>

               
                <!-- Flash message if Success -->
				@if(session()->has('flashMessageX'))
                    <div class="alert alert-success">
                        {!! session()->get('flashMessageX') !!} <!--Displays content without html escaping -->
                    </div>
                @endif
				<!-- Flash message -->
				
                <!-- Flash message if Failed -->
				@if(session()->has('flashMessageFailX'))
                    <div class="alert alert-danger">
                        {!! session()->get('flashMessageFailX') !!} <!--Displays content without html escaping -->
                    </div>
                @endif
				<!-- Flash message if Failed -->				
				
                <!-- Display form validation errors var 2 -->
				@if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
                <!-- End Display form validation errors var 2 -->	
                

                <div class="alert alert-danger">
                    Login form action route changed from 'login' to Api auth route => 'passport_login' 
                </div> 
                
                
				<div class="alert alert-danger">
                    Don't use this 1st from (it is authentic Laravel form), use the second one below (Vue Form) 
                </div> 
                
                
                <!-- This Login form is no longer used (was OK for regular hhtp), reassigned to REST API <login-vue-component> <login-vue-component/> -->
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('passport_login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                           <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="dont use me, use Vue form" required autofocus>
                                
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif 
							</div>
                        </div>	
								
								
								
						<!-- If u want to Login with username instead of Email -->
						<!--
						<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
						    <label for="name" class="col-md-4 control-label">name</label>
						    <div class="col-md-6">
								<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required >
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
							</div>
						</div>
						-->
						<!-- End If u want to Login with username instead of Email -->
								
								
                            
                        

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                                <i class="fa fa-eye" id="togglePassword" style="cursor:pointer;"></i>
								
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" onclick="alert('Do not use this form. Use Vue form'); return false;">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End This Login form is no longer used (was OK for regular hhtp), reassigned to REST API <login-vue-component> <login-vue-component/> -->


            </div>
        </div>
    </div>
</div>


<div class="col-md-9 col-md-offset-2 alert alert-danger">
    <center>If see no Vue login form below, check if the JS is not corrupted</center>
</div>


<!----------------------------- Vue Login component (Rest Api Login) ---------------------------------->
<div id="vue-login" class="col-md-9 col-md-offset-2">
    <login-vue-component> <login-vue-component/>
</div>
<!------------------------------ END Vue Login component ----------------------------------------------->



<!-- Include js file for thisview only -->
<script src="{{ asset('js/login/login.js')}}"></script>
<!-- Include js file for thisview only -->

@endsection





