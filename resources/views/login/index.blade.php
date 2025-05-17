@extends('layouts.main')

@section('title', 'Login')

@section('content')
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row justify-content-center w-100">
      <div class="col-md-6">
        <div class="card shadow-lg p-4 rounded" style="max-width: 500px; margin: auto;">
          <h2 class="text-center my-2">Login</h2>
          @if (session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('loginError') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
          <div class="card-body">
            <form class="form form-vertical" action="{{ route('login') }}" method="POST">
              @csrf
              <div class="form-body">
                <div class="form-group has-icon-left mb-3">
                  <label for="email-id-icon">Email</label>
                  <div class="position-relative">
                    <input type="email" name="email"
                      class="form-control form-control-user @error('email') is-invalid @enderror" id="email-id-icon"
                      placeholder="Enter Email Address..." value="{{ old('email') }}" required autofocus>
                    <div class="form-control-icon">
                      <i class="bi bi-envelope"></i>
                    </div>
                    @error('email')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="form-group has-icon-left mb-3">
                  <label for="password-id-icon">Password</label>
                  <div class="position-relative">
                    <input type="password" name="password" class="form-control" placeholder="Password"
                      id="password-id-icon" required>
                    <div class="form-control-icon">
                      <i class="bi bi-lock"></i>
                    </div>
                  </div>
                </div>
                <div class="form-check mb-3">
                  <input type="checkbox" name="remember" id="remember-me-v" class="form-check-input" checked>
                  <label for="remember-me-v">Remember Me</label>
                </div>
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary">Login</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
