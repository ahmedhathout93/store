@extends('layouts.dashboard')

@section ('title','Products')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Products</li>

@endsection

@section('content')

<div class="mb-5">

    <a href="{{ route('dashboard.products.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
</div>
<x-form.alert type="success" />

<form action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4">
    <x-form.input name="name" placeholder="Name" :value="request('name')" class="mx-2" />
    <select name="status" class="form-control" class="mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status')=='active' )>Active</option>
        <option value="archived" @selected(request('status')=='archived' )>Archived</option>
    </select>
    <button class="btn btn-dark mx-2">Filter</button>
</form>

<table class="table text-center ">
    <thead>
        <tr>
            <th>Image</th>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
        <tr>
            <td class="align-middle "><img class="cat-icon" src="{{asset('storage/'.$product->image)}}" alt="" height="70px"></td>
            <td class="align-middle">{{ $product->id }}</td>
            <td class="align-middle">{{ $product->name }}</td>
            <td class="align-middle">{{ $product->category->name }}</td>
            <td class="align-middle">{{ $product->store->name }}</td>
            <td class="align-middle">{{ $product->status }}</td>
            <td class="align-middle">{{ $product->created_at }}</td>
            <td class="align-middle">
                <a href="{{ route('dashboard.products.edit' , $product->id ) }}" class="btn btn-sm btn-outline-success">Edit</a>
            </td>
            <td class="align-middle">
                <form action="{{ route('dashboard.products.destroy', $product->id ) }}" method="post">
                    @method('DELETE')
                    @csrf
                    <button type=" submit" class="button btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <th colspan="9">No products defined.</th>
        </tr>
        @endforelse
    </tbody>
</table>

{{$products->withQueryString()->links()}}

@endsection