<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Guardian;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->hasRole('super-admin|admin')) {
            $parents = Guardian::with('students')->latest()->get();
            $teachers = Teacher::with('subjects', 'classes')->latest()->get();
            $students = Student::with('parent')->latest()->get();
            $classes = Grade::with('students')->latest()->get();
            return view('home', compact('parents', 'teachers', 'students', 'classes'));
        } elseif ($user->hasRole('teacher')) {
            $teacher = Teacher::with('user', 'subjects', 'classes')->withCount('subjects', 'classes')->findOrFail($user->teacher->id);
            return view('home', compact('teacher'));
        } elseif ($user->hasRole('parent')) {
            $parent = Guardian::with('students')->withCount('students')->findOrFail($user->parent->id);
            return view('home', compact('parent'));
        } elseif ($user->hasRole('student')) {
            $student = Student::with('user', 'parent', 'grade')->findOrFail($user->student->id);
            return view('home', compact('student'));
        } else {
            return view('welcome');
        }
    }
}
