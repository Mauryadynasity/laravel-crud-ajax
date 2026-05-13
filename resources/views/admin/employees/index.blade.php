@extends('layouts.app')
@section('title', 'Employee List')
@section('content')
    <nav class="container mt-3">
            <div class="d-flex justify-content-end">
                <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">
                    Hi, {{ Auth::user()->full_name }}
                </h4>
                <form action="/log-out" method="POST">
                    @csrf
                    <button class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            Employee List
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Qualifications</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td>{{ $employee->full_name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>
                                @foreach($employee->qualifications as $q)
                                    <span class="badge bg-secondary mb-1">
                                        {{ $q->qualification_name }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                <a href="/admin/employee/{{ $employee->id }}" class="btn btn-sm btn-info">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">
                                No employees found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection