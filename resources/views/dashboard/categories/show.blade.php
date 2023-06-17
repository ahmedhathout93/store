@extends('layouts.dashboard')

@section ('title',$category->name)

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
<li class="breadcrumb-item active">{{$category->name}}</li>

@endsection

@section('content')



<table class="table text-center ">
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @php
$products= $category->products()->with('store')->paginate(2)
        @endphp

        @forelse( $products as $product)
        <tr>
            <td class="align-middle "><img class="cat-icon" src="{{asset('storage/'.$product->image)}}" alt="" height="70px"></td>
            <td class="align-middle">{{ $product->name }}</td>
            <td class="align-middle">{{ $product->store->name}}</td>
            <td class="align-middle">{{ $product->status }}</td>
            <td class="align-middle">{{ $product->created_at }}</td>
            
        </tr>
        @empty
        <tr>
            <th colspan="5">No categories defined.</th>
        </tr>
        @endforelse
    </tbody>
</table>

{{$products->withQueryString()->links()}}

@endsection