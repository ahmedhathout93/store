<div class="form-group">
    <x-form.input name="name" label="Category name" :value="$category->name" />
</div>
<div class="form-group">
    <label for="">Category parent</label>
    <select name="parent_id" @class([ 'form-control' , 'is-invalid'=>$errors->has('parent_id')
        ])>
        <option value="">Primary category</option>
        @foreach ($parents as $parent)
        <option value="{{$parent->id}}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name }}</option>
        @endforeach
    </select>
    @error('parent_id')
    <div class="text-danger">
        {{$message}}
    </div>
    @enderror
</div>
<div class="form-group">
    <x-form.textarea name="description" label="Description" :value="$category->description" />
</div>
<div class="form-group">
    <x-form.input type="file" name="image" label="Image" />
    @if($category->image)
    <img src="{{asset('storage/'.$category->image)}}" alt="" height="70px">
    @endif
    @error('image')
    <div class="text-danger">
        {{$message}}
    </div>
    @enderror
</div>
<div class="form-group">
    <label for="">Status</label>
    <div>
<x-form.radio name="status" :checked="$category->status" :options="['archived'=>'Archived' ,'active'=>'Active']" />
    </div>
</div>
<div class="form-group mt-3">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>