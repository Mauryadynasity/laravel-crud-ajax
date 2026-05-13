@extends('layouts.app')
@section('title', 'Employee Details')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Employee Details</h4>
     <div class="card-header bg-success text-white">
    <a href="/admin/dashboard" class="btn btn-secondary">Back</a>        
    </div>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <div class="row mb-4 align-items-center">
            <div class="col-md-3 text-center">
                @if($user->profile_image)
                    <img src="{{ asset('storage/'.$user->profile_image) }}" 
                         class="img-fluid rounded-circle border"
                         style="width:150px; height:150px; object-fit:cover;">
                @else
                    <div class="border rounded-circle d-flex align-items-center justify-content-center"
                         style="width:150px; height:150px;">
                        No Image
                    </div>
                @endif
            </div>
            <div class="col-md-9">
                <h5>{{ $user->full_name }}</h5>
                <p class="mb-1"><b>Email:</b> {{ $user->email }}</p>
                <p class="mb-1"><b>DOB:</b> {{ $user->dob }}</p>
                <p class="mb-0"><b>Age:</b> {{ $user->age }}</p>
            </div>
        </div>
        <hr>

        <div class="mb-4">
            <h5>Qualifications</h5>
            @forelse($user->qualifications as $q)
                <span class="badge bg-primary me-1 mb-1">
                    {{ $q->qualification_name }}
                </span>
            @empty
                <p class="text-muted">No qualifications added</p>
            @endforelse
        </div>

        <div class="mb-4">
            <h5>Experiences</h5>
            @forelse($user->experiences as $exp)
                <div class="border rounded p-2 mb-2">
                    {{ $exp->company_name }}
                </div>
            @empty
                <p class="text-muted">No experience added</p>
            @endforelse
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <h5>Permanent Address</h5>
                @forelse($user->addresses->where('type','permanent') as $addr)
                    <div class="border rounded p-2">
                        {{ $addr->address_line1 }},
                        {{ $addr->address_line2 }},
                        {{ $addr->city }},
                        {{ $addr->state }}
                    </div>
                @empty
                    <p class="text-muted">No permanent address</p>
                @endforelse
            </div>

            <div class="col-md-6 mb-3">
                <h5>Current Address</h5>
                @forelse($user->addresses->where('type','current') as $addr)
                    <div class="border rounded p-2">
                        {{ $addr->address_line1 }},
                        {{ $addr->address_line2 }},
                        {{ $addr->city }},
                        {{ $addr->state }}
                    </div>
                @empty
                    <p class="text-muted">No current address</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection