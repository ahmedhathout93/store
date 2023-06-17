<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $request = request(); //filter form


        $categories = Category::with('parent') /* leftjoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select(
                'categories.*',
                'parents.name as parent_name'
            )*/
            ->withCount([
                'products as products_number' => function ($query) {
                    $query->where('status', '=', 'active');
                }
            ])
            ->filter($request->query())->paginate(5);
        // $query = Category::query(); //database

        // if ($name = $request->query('name')) {
        //     $query->where('name', 'LIKE', "%{$name}%");
        // }
        // if ($status = $request->query('status')) {
        //     $query->where('status', '=', "$status");
        // }
        // $categories = Category::Filter($request->query())->paginate(2);
        // $categories = $query->paginate(2); // return collection object
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all(); // return collection object
        $category = new Category(); //
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(Category::rules());

        $request->merge(['slug' => Str::slug($request->post('name'))]);
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uploads', 'public');
            $data['image'] = $path;
        }

        $category = Category::create($data);
        return Redirect::route('dashboard.categories.index')->with('success', 'Category created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show' , [
            'category'=>$category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $parents = Category::where('id', '<>', $id) // category can't be parent of itself
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id') // to include new or null parent value
                    ->orwhere('parent_id', '<>', $id); // two categories can't be parent of themselves
            })
            ->get();
        $category = Category::findOrFail($id);
        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(Category::rules($id));

        $category = Category::find($id);
        $old_image = $category->image;

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uploads', 'public');
            $data['image'] = $path;
        }
        $category->update($data);
        if ($old_image && isset($data['image'])) {
            Storage::disk('public')->delete($old_image);
        }

        return Redirect::route('dashboard.categories.index')->with('success', 'Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return Redirect::route('dashboard.categories.index')->with('success', 'Category deleted!');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.trash')->with('success', 'Category restored !');
    }
    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')->with('success', 'Category deleted forever !');
    }
}
