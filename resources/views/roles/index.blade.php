@extends('layouts.dashboard')

@section('page-title')
    Roles <small><a href="{{ route('roles.create') }}" class="btn btn-sm btn-outline-primary">Create</a></small>
@endsection

@section('content')

<x-flash-message />

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Users #</th>
                <th>Created At</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td><a href="{{ route('roles.show', ['role' => $role->id]) }}">{{ $role->name }}</a></td>
                <td>{{ $role->users_count }}</td>
                <td>{{ $role->created_at }}</td>
                <td><a href="{{ route('roles.edit', [$role->id]) }}" class="btn btn-sm btn-dark">Edit</a></td>
                <td>
                    <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $roles->withQueryString()->links() }}

@endsection