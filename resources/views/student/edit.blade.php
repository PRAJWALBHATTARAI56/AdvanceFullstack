@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
    <h1>Edit Student</h1>
    <form action="{{ route('students.update', $student) }}" method="POST">
        @csrf
        @method('PUT')
        @include('student._form')
        <button type="submit" class="btn">Update Student</button>
        <a href="{{ route('students.show', $student) }}">Cancel</a>
    </form>
@endsection
