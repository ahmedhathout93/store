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
<x-form.alert type="success" />

<table class="table text-center ">
    <thead>
        <tr>
            <th >Image</th>
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
            <td class="align-middle "><img class="cat-icon" src="{{asset('storage/'.$category->image)}}" alt="" height="70px"></td>
            <td class="align-middle">{{ $category->id }}</td>
            <td class="align-middle">{{ $category->name }}</td>
            <td class="align-middle">{{ $category->parent_id }}</td>
            <td class="align-middle">{{ $category->created_at }}</td>
            <td class="align-middle">
                <a href="{{ route('dashboard.categories.edit' , $category->id ) }}" class="btn btn-sm btn-outline-success">Edit</a>
            </td>
            <td class="align-middle">
                <form action="{{ route('dashboard.categories.destroy', $category->id ) }}" method="post">
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