@extends('layouts.dashboard')

@section('page-title', 'Edit Role')

@section('content')

        <form action="{{ route('roles.update', $role->id) }}" method="post">
            @csrf
            @method('put')
            
            @include('roles._form')
        </form>

@endsection