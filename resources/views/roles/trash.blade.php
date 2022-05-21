@extends('layouts.dashboard')

@section('page-title')
    Deleted Categories <small><a href="{{ route('categories.create') }}" class="btn btn-sm btn-outline-primary">Create</a></small>
@endsection

@section('content')

<x-flash-message />

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Parent ID</th>
                <th>Deleted At</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td><a href="{{ route('categories.show', ['category' => $category->id]) }}">{{ $category->name }}</a></td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->parent->name }}</td>
                <td>{{ $category->deleted_at }}</td>
                <td>
                    <form action="{{ route('categories.restore', $category->id) }}" method="post">
                        @csrf
                        @method('put')
                        <button class="btn btn-sm btn-info">Restore</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('categories.forceDelete', $category->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm btn-danger">Delete Forever</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $categories->withQueryString()->appends(['q' => 'test'])->links() }}

@endsection