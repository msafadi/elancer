@extends('layouts.dashboard')

@section('page-title', 'Create Category')

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $message)
        <li>{{ $message }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('categories.store') }}" method="post">
    @csrf

    @include('categories._form')
</form>

@endsection