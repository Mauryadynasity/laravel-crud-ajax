<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = \App\Models\User::with(['qualifications','experiences','addresses'])
                ->where('is_admin', 0)
                ->get();
        return view('admin.employees.index', compact('employees'));
    }

    public function show($id)
    {
        $user = \App\Models\User::with(['qualifications','experiences','addresses'])
                ->find($id);

        return view('admin.employees.employee_view', compact('user'));
    }

}