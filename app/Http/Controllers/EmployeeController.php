<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Employee;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\Password;

class EmployeeController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        // dd($request->input('profile_picture_path'));
        $data = $request->all();

        if($request->hasFile('profile_photo_path')) {
            $data['profile_photo_path'] = $request->file('profile_photo_path')->store('images', 'public');
        } else {
            $data['profile_photo_path'] = "";
        }
        
        $defaultPassword = '12345678';

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($defaultPassword),
                'profile_photo_path' => $data['profile_photo_path']
            ]);

            // dump($user);
            $employee = Employee::create([
                'user_id' => $user->id,
                'job_title_id' => $data['job_title_id'],
                'salary' => $data['salary'],
                'department_id' => $data['department']
            ]);
            // dd($employee);
            
            $token = Password::createToken($user);
            Mail::to($user->email)->send(new ResetPassword($token, $user->name));
            session()->flash('success', "Employee created successfully.");
            DB::commit();
            
        } catch(\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            session()->flash('failed', "Employee's account creation failed.");
        }
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', ['employee' => $employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $data = $request->all();

        try {
            \DB::beginTransaction();

            if($request->hasFile('profile_photo_path')) {
                $data['profile_photo_path'] = $request->file('profile_photo_path');
            }

            $employee->user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'profile_photo_path' => $data['profile_photo_path'] ?? $employee->user->profile_photo_path
            ]);

            $employee->update([
                'job_title_id' => $data['job_title_id'],
                'salary' => $data['salary'],
                'department_id' => $data['department']
            ]);

            \DB::commit();
            session()->flash('success', "Employee updated successfully");
        } catch(\Exception $e) {
            \DB::rollback();
            dd($e->getMessage());
        }
        
        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        // dd($employee);
        $employee->delete();
        return redirect()->route('employees.index');
    }
}
