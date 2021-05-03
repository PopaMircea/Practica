@extends('base')

@section('content')
    

    <div class="register-box">
        <div class="register-logo">
          <a href="{{route('register')}}"><b>Admin</b>LTE</a>
        </div>
      
        <div class="card">
          <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new membership</p>
            @if ($errors->has('register'))
                    <div class="alert alert-danger">{{$errors->first('register')}}</div> @endif
            <form action="{{ route('register') }}" method="post">
              @csrf
              @if ($errors->has('name'))
              <div class="alert alert-danger">{{$errors->first('name')}}</div> @endif
              <div class="input-group mb-3">
                <input name="name" type="text" class="form-control @if ($errors->has('name')) is-invalid @endif" placeholder="Full name">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fa fa-user"></span>
                  </div>
                </div>
              </div>
              @if ($errors->has('email'))
              <div class="alert alert-danger">{{$errors->first('email')}}</div> @endif
              <div class="input-group mb-3">
                <input name="email" type="email" class="form-control @if ($errors->has('email')) is-invalid @endif" placeholder="Email">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fa fa-envelope"></span>
                  </div>
                </div>
              </div>
              @if ($errors->has('password'))
              <div class="alert alert-danger">{{$errors->first('password')}}</div> @endif
              <div class="input-group mb-3">
                <input name="password" type="password" class="form-control @if ($errors->has('password')) is-invalid @endif" placeholder="Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fa fa-lock"></span>
                  </div>
                </div>
              </div>
             
              <div class="input-group mb-3">
                <input name="password_confirmation" type="password" class="form-control" placeholder="Retype password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fa fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <div class="icheck-primary">
                    <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                    <label for="agreeTerms">
                     I agree to the <a href="#">terms</a>
                    </label>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
      
            <div class="social-auth-links text-center">
              <p>- OR -</p>
              <a href="#" class="btn btn-block btn-primary">
                <i class="fa fa-facebook mr-2"></i>
                Sign up using Facebook
              </a>
              <a href="#" class="btn btn-block btn-danger">
                <i class="fa fa-google-plus mr-2"></i>
                Sign up using Google+
              </a>
            </div>
      
            <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
          </div>
          <!-- /.form-box -->
        </div><!-- /.card -->
      </div>
      <!-- /.register-box -->
      @endsection