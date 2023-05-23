@extends('layouts.dashboard')

@section ('title','Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>

@endsection

@section('content')

<div class="mb-5">

<a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-primary">Create</a>
</div>
@if(session()->has('success'))
<div class="alert alert-success">{{session('success')}}</div>
@endif
<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td></td>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->parent_id }}</td>
            <td>{{ $category->created_at }}</td>
            <td>
                <a href="{{ route('dashboard.categories.edit' , $category->id ) }}" class="btn btn-sm btn-outline-success">Edit</a>
            </td>
            <td>
                <form action="{{ route('dashboard.categories.destroy', $category->id ) }}" method="post" >
                    @method('DELETE')
                    @csrf
                    <button type=" submit" class="button btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <th colspan="6">No categories defined.</th>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection

