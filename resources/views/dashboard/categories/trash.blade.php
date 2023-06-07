@extends('layouts.dashboard')

@section ('title','Trashed Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
<li class="breadcrumb-item active">Trash</li>

@endsection

@section('content')

<div class="mb-5">

    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-sm btn-outline-primary">Back</a>
</div>
<x-form.alert type="success" />

<form action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4">
    <x-form.input name="name" placeholder="Name" :value="request('name')" class="mx-2"/>
    <select name="status" class="form-control" class="mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status')== 'active')>Active</option>
        <option value="archived" @selected(request('status')== 'archived')>Archived</option>
    </select>
    <button class="btn btn-dark mx-2">Filter</button>
</form>

<table class="table text-center ">
    <thead>
        <tr>
            <th >Image</th>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Deleted At</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td class="align-middle "><img class="cat-icon" src="{{asset('storage/'.$category->image)}}" alt="" height="70px"></td>
            <td class="align-middle">{{ $category->id }}</td>
            <td class="align-middle">{{ $category->name }}</td>
            <td class="align-middle">{{ $category->status }}</td>
            <td class="align-middle">{{ $category->deleted_at }}</td>
            <td class="align-middle">
                <form action="{{ route('dashboard.categories.restore', $category->id ) }}" method="post">
                    @method('put')
                    @csrf
                    <button type=" submit" class="button btn btn-sm btn-outline-info">Restore</button>
                </form>
            </td>
            <td class="align-middle">
                <form action="{{ route('dashboard.categories.force-delete', $category->id ) }}" method="post">
                    @method('DELETE')
                    @csrf
                    <button type=" submit" class="button btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <th colspan="8">No trashed categories .</th>
        </tr>
        @endforelse
    </tbody>
</table>

{{$categories->withQueryString()->links()}}

@endsection