@extends('layouts.app')
@section('title', 'Register')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">Employee Registration Form</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                            <a href="login">Login Here</a>
                        </div>
                    @endif
                        <form action="/signup" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input class="form-control" type="text" name="full_name"
                                        value="{{ old('full_name') }}" placeholder="Full Name*">
                                    @error('full_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input class="form-control" type="date" name="dob"
                                        value="{{ old('dob') }}">
                                    @error('dob') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <img id="preview-image" src="" 
                                        style="display:none; width:45%; border-radius:34%;" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input class="form-control" type="number" name="age"
                                        value="{{ old('age') }}" placeholder="Age*">
                                    @error('age') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input class="form-control" type="email" name="email"
                                        value="{{ old('email') }}" placeholder="Email*">
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                 <div class="col-md-6">
                                    <input class="form-control" type="file" name="profile_image" onchange="previewImage(event)">
                                    @error('profile_image') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input class="form-control" type="password" name="password" placeholder="Password*">
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password*">
                                    @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <h5>Qualifications</h5>
                            <div id="qualification-wrapper" class="mb-3">
                                <input class="form-control mb-2" type="text" name="qualifications[]" placeholder="Qualification">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary mb-3" onclick="addQualification()">Add More</button>

                            <h5>Experience</h5>
                            <div id="experience-wrapper" class="mb-3">
                                <input class="form-control mb-2" type="text" name="experiences[]" placeholder="Experience">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary mb-3" onclick="addExperience()">Add More</button>

                            <h5>Permanent Address</h5>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input class="form-control" name="permanent[address_line1]" placeholder="Address Line 1">
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" name="permanent[address_line2]" placeholder="Address Line 2">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input class="form-control" name="permanent[city]" placeholder="City">
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" name="permanent[state]">
                                        <option value="">Select State</option>
                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                        <option value="Delhi">Delhi</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <h5>Current Address</h5>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <input class="form-control" name="current[address_line1]" placeholder="Address Line 1">
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" name="current[address_line2]" placeholder="Address Line 2">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input class="form-control" name="current[city]" placeholder="City">
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" name="current[state]">
                                        <option value="">Select State</option>
                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                        <option value="Delhi">Delhi</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection