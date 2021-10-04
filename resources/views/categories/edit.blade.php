@extends('layouts.dashboard')

@section('page-title', 'Edit Category')

@section('content')

        <form action="/categories/{{ $category->id }}" method="post">
            @csrf
            @method('put')
            
            @include('categories._form')
        </form>

@endsection