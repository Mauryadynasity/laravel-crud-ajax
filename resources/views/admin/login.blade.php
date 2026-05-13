@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="container">

    <div class="row justify-content-center align-items-center" style="height:100vh;">
        
        <div class="col-md-5">

            <div class="card shadow-lg p-4">
                
                <h3 class="text-center mb-4">Admin Login</h3>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="/admin/login" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        Login
                    </button>
                </form>

            </div>

        </div>

    </div>

</div>

@endsection