@extends('layouts.dashboard')

@section('page-title', 'Edit Category')

@section('content')

        <form action="{{ route('categories.update', $category->id) }}" method="post">
            @csrf
            @method('put')
            
            @include('categories._form')
        </form>

@endsection