@extends('layouts.dashboard')

@section ('title','Edit category')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
<li class="breadcrumb-item active">Edit category</li>

@endsection

@section('content')

<form action="{{ route('dashboard.categories.update' , $category->id) }}" method="post" enctype = "multipart/form-data">
    @method('PUT')
    @csrf
    <div class="form-group">
        <label for="">Category name</label>
        <input type="text" name="name" class="form-control" value="{{$category->name}}">
    </div>
    <div class="form-group">
        <label for="">Category parent</label>
        <select name="parent_id" class="form-control">
            <option value="">Primary category</option>
            @foreach ($parents as $parent)
            <option value="{{$parent->id}}" @selected($parent->id == $category->parent_id)>{{$parent->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="">Description</label>
        <textarea name="description" class="form-control">{{$category->description}}</textarea>
    </div>
    <div class="form-group">
        <label for="">Image</label>
        <input type="file" name="image" class="form-control">
        @if($category->image)
        <img src="{{asset('storage/'.$category->image)}}" alt="" height="70px">
        @endif
    </div>
    <div class="form-group">
        <label for="">Status</label>
        <div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" value="active" @checked($category->status == 'active')>
                <label class="form-check-label">
                    Active
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" value="archived" @checked($category->status == 'archived')>
                <label class="form-check-label">
                    Archived
                </label>
            </div>
        </div>
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
</form>

@endsection