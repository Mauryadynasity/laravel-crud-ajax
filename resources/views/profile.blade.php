@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <nav class="container mt-3">
            <div class="d-flex justify-content-end">
                <form action="/logout" method="POST">
                    @csrf
                    <button class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </nav>
        <div class="col-md-8">
            <div class="card shadow p-4">
                <h3 class="text-center mb-3">Employee Profile</h3>
                <div class="text-center mb-4">
                    @if($user->profile_image)
                        <img id="profile-img" 
                             src="{{ asset('storage/'.$user->profile_image) }}" 
                             class="rounded-circle border shadow"
                             width="120" height="120">
                    @endif
                    <div class="mt-2 field">
                        <input type="file" class="edit-input form-control">
                        <button class="btn btn-sm btn-secondary mt-1" onclick="enableEdit(this)">Edit</button>
                    </div>
                </div>
                <div class="field mb-3">
                    <b>Full Name:</b>
                    <span class="text d-block full_name_text">{{ $user->full_name }}</span>
                    <input type="text" name="full_name" class="edit-input form-control mt-1" value="{{ $user->full_name }}">
                    <button class="btn btn-sm btn-secondary mt-1" onclick="enableEdit(this)">Edit</button>
                </div>
                <div class="field mb-3">
                    <b>Date of Birth:</b>
                    <span class="text d-block dob_text">{{ $user->dob }}</span>
                    <input type="text" name="dob" class="edit-input form-control mt-1" value="{{ $user->dob }}">
                    <button class="btn btn-sm btn-secondary mt-1" onclick="enableEdit(this)">Edit</button>
                </div>
                <div class="mb-3">
                    <b>Email:</b>
                    <p>{{ $user->email }}</p>
                </div>
                <div class="field mb-3">
                    <b>Age:</b>
                    <span class="text d-block age_text">{{ $user->age }}</span>
                    <input type="number" name="age" class="edit-input form-control mt-1" value="{{ $user->age }}">
                    <button class="btn btn-sm btn-secondary mt-1" onclick="enableEdit(this)">Edit</button>
                </div>

                <h5 class="text-primary">Qualifications</h5>
                <div id="qualifications">
                    @foreach($user->qualifications as $q)
                        <div class="field mb-2" id="qualification-wrapper">
                            <span class="text d-block qualification_text">{{ $q->qualification_name }}</span>
                            <input type="text" class="edit-input form-control mt-1" value="{{ $q->qualification_name }}">
                            <button class="btn btn-sm btn-secondary mt-1" onclick="enableEdit(this)">Edit</button>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-outline-success btn-sm mb-3" onclick="addQualification()">Add More</button>

                <h5 class="text-primary">Experiences</h5>
                <div id="experiences">
                    @foreach($user->experiences as $exp)
                        <div class="field mb-2" id="experience-wrapper">
                            <span class="text d-block experience_text">{{ $exp->company_name }}</span>
                            <input type="text" class="edit-input form-control mt-1" value="{{ $exp->company_name }}">
                            <button class="btn btn-sm btn-secondary mt-1" onclick="enableEdit(this)">Edit</button>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-outline-success btn-sm mb-3" onclick="addExperience()">Add More</button>

                <h5 class="text-primary">Permanent Address</h5>
                @foreach($user->addresses->where('type','permanent') as $addr)
                <div class="row mb-3">
                    <div class="col-md-6 field">
                        <b>Line 1</b>
                        <p class="text">{{ $addr->address_line1 }}</p>
                        <input type="text" class="edit-input form-control permanent_line1" value="{{ $addr->address_line1 }}">
                        <button class="btn btn-sm btn-secondary mt-1" onclick="enableEdit(this)">Edit</button>
                    </div>
                    <div class="col-md-6 field">
                        <b>Line 2</b>
                        <p class="text">{{ $addr->address_line2 }}</p>
                        <input type="text" class="edit-input form-control permanent_line2" value="{{ $addr->address_line2 }}">
                        <button class="btn btn-sm btn-secondary mt-1" onclick="enableEdit(this)">Edit</button>
                    </div>
                    <div class="col-md-6 field">
                        <b>City</b>
                        <p class="text">{{ $addr->city }}</p>
                        <input type="text" class="edit-input form-control permanent_city" value="{{ $addr->city }}">
                        <button class="btn btn-sm btn-secondary mt-1" onclick="enableEdit(this)">Edit</button>
                    </div>
                    <div class="col-md-6 field">
                        <b>State</b>
                        <p class="text">{{ $addr->state }}</p>

                        <select class="edit-input form-control permanent_state">
                            <option value="">Select State</option>
                            <option value="Uttar Pradesh" {{ $addr->state == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                            <option value="Delhi" {{ $addr->state == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                            <option value="Bihar" {{ $addr->state == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                        </select>
                        <button class="btn btn-sm btn-secondary mt-1" onclick="enableEdit(this)">Edit</button>
                    </div>
                </div>
                @endforeach

                <h5 class="text-primary">Current Address</h5>
                @foreach($user->addresses->where('type','current') as $addr)
                <div class="row mb-3">
                    <div class="col-md-6 field">
                        <b>Line 1</b>
                        <p class="text">{{ $addr->address_line1 }}</p>
                        <input type="text" class="edit-input form-control current_line1" value="{{ $addr->address_line1 }}">
                        <button class="btn btn-sm btn-secondary mt-1" onclick="enableEdit(this)">Edit</button>
                    </div>
                    <div class="col-md-6 field">
                        <b>Line 2</b>
                        <p class="text">{{ $addr->address_line2 }}</p>
                        <input type="text" class="edit-input form-control current_line2" value="{{ $addr->address_line2 }}">
                        <button class="btn btn-sm btn-secondary mt-1" onclick="enableEdit(this)">Edit</button>
                    </div>
                    <div class="col-md-6 field">
                        <b>City</b>
                        <p class="text">{{ $addr->city }}</p>
                        <input type="text" class="edit-input form-control current_city" value="{{ $addr->city }}">
                        <button class="btn btn-sm btn-secondary mt-1" onclick="enableEdit(this)">Edit</button>
                    </div>

                    <div class="col-md-6 field">
                        <b>State</b>
                        <p class="text">{{ $addr->state }}</p>

                        <select class="edit-input form-control current_state">
                            <option value="">Select State</option>
                            <option value="Uttar Pradesh" {{ $addr->state == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                            <option value="Delhi" {{ $addr->state == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                            <option value="Bihar" {{ $addr->state == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                        </select>
                        <button class="btn btn-sm btn-secondary mt-1" onclick="enableEdit(this)">Edit</button>
                    </div>
                </div>
                @endforeach
                <button class="btn btn-success w-100" onclick="saveProfile()">Save Changes</button>
                <h3 id="success-msg" class="text-success mt-2"></h3>
            </div>
        </div>
    </div>
</div>

@endsection