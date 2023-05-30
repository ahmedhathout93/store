@extends('layouts.dashboard')

@section ('title','Edit category')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
<li class="breadcrumb-item active">Edit category</li>

@endsection

@section('content')

<form action="{{ route('dashboard.categories.update' , $category->id) }}" method="post" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    @include('dashboard.categories._form', [
    'button_label' => 'Update'
    ])
</form>

@endsection