<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    // Actions
    public function index($slug, $id = 0)
    {
        //$categories = DB::table('categories')->get();
        $categories = Category::get();

        //$flashMessage = session('success', false);
        //$flashMessage = session()->get('success', false);
        $flashMessage = Session::get('success', false);
        Session::forget('success');

        return view('categories.index', [
            'categories' => $categories,
            'title' => 'Categories',
            'flashMessage' => $flashMessage,
        ]);
    }

    public function show($id)
    {
        // $category = DB::table('categories')
        //     ->where('id', '=', $id)
        //     ->first();
        
        // $category = Category::where('id', '=', $id)->firstOrFail();
        $category = Category::findOrFail($id);
        
        // if ($category == null) {
        //     abort(404);
        // }

        return view('categories.show', [
            'category' => $category,
        ]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        //     $request->name;
        //     $request->input('name');
        //     $request->post('name'); // Only post, put, patch requests
        //     $request->get('name');
        //     $request['name'];
        //     $request->query('name'); // Only query parameters

        //DB::table('categories')->insert([]);
        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->parent_id = $request->input('parent_id');
        $category->slug = Str::slug($category->name);
        $category->save();

        // PRG: Post Redirect Get
        return redirect('/categories')
            ->with('success', 'Category created!');

    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->parent_id = $request->input('parent_id');
        $category->slug = Str::slug($category->name);        
        $category->save();

        return redirect('/categories')
            ->with('success', 'Category updated!');
    }

    public function destroy($id)
    {
        // DB::table('categories')->where('id', $id)->delete();
        // Category::where('id', $id)->delete();
        Category::destroy($id);

        // $category = Category::findOrFail($id);
        // $category->delete();

        //session()->flash('success', 'Category deleted!');
        //Session::flash('success', 'Category deleted!');
        Session::put('success', 'Category deleted!');

        return redirect('/categories');
            //->with('success', 'Category deleted!');

    }

}
