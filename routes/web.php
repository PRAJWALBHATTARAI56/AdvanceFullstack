<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Student;

Route::get('/', function () {
    return view('welcome');
});

// Step 12: List Route
Route::get('/students', function () {
    $students = Student::all();
    return view('student.list', ['students' => $students]);
})->name('students.index');

// Step 9: Create Form
Route::get("/students/create", function () {
    return view("student.create");
});

// Step 9 & 10: Store Student
Route::post("/students", function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:students',
        'phone' => 'required|string|max:20',
        'address' => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);
    
    $student = Student::create($validated);
    
    return redirect()->route('students.index')
        ->with('success', "Student {$student->name} created successfully!");
});

// Step 10 (detail): Show Detail
Route::get('/students/{id}', function ($id) {
    $student = Student::findOrFail($id);
    return view('student.detail', ['student' => $student]);
});

// Step 11: Edit Form
Route::get('/students/{id}/edit', function ($id) {
    $student = Student::findOrFail($id);
    return view('student.edit', ['student' => $student]);
});

// Step 11: Update Student
Route::put('/students/{id}', function (Request $request, $id) { 
    $student = Student::findOrFail($id); 
    
    $validated = $request->validate([ 
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', 'max:255', Rule::unique('students')->ignore($student->id)], 
        'phone' => 'required|string|max:20', 
        'address' => 'nullable|string', 
        'date_of_birth' => 'nullable|date', 
    ]);
                 
    $student->update($validated); 
    
    return redirect('/students/' . $student->id)
        ->with('success', 'Student updated successfully!'); 
});

// Step 12: Delete Student
Route::delete('/students/{id}', function ($id) {
    $student = Student::findOrFail($id);
    $student->delete();
    
    return redirect('/students')
        ->with('success', 'Student deleted successfully!');
});

use App\Models\Course;

// COURSE CRUD

Route::get('/courses', function () {
    $courses = Course::all();
    return view('course.list', ['courses' => $courses]);
})->name('courses.index');

Route::get("/courses/create", function () {
    return view("course.create");
});

Route::post("/courses", function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'duration' => 'required|integer|min:1',
        'fee' => 'required|numeric|min:0',
        'difficulty' => 'required|in:Easy,Medium,Hard',
        'is_active' => 'boolean',
    ]);
    
    $course = Course::create($validated);
    
    return redirect()->route('courses.index')
        ->with('success', "Course {$course->name} created successfully!");
});

Route::get('/courses/{id}', function ($id) {
    $course = Course::findOrFail($id);
    return view('course.detail', ['course' => $course]);
});

Route::get('/courses/{id}/edit', function ($id) {
    $course = Course::findOrFail($id);
    return view('course.edit', ['course' => $course]);
});

Route::put('/courses/{id}', function (Request $request, $id) { 
    $course = Course::findOrFail($id); 
    
    $validated = $request->validate([ 
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'duration' => 'required|integer|min:1',
        'fee' => 'required|numeric|min:0',
        'difficulty' => 'required|in:Easy,Medium,Hard',
        'is_active' => 'boolean',
    ]);
                 
    $course->update($validated); 
    
    return redirect('/courses/' . $course->id)
        ->with('success', 'Course updated successfully!'); 
});

Route::delete('/courses/{id}', function ($id) {
    $course = Course::findOrFail($id);
    $course->delete();
    
    return redirect('/courses')
        ->with('success', 'Course deleted successfully!');
});
