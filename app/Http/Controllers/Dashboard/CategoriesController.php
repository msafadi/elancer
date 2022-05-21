<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Rules\FilterRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    protected $rules = [
        'name' => [
            'required', 
            'string', 
            'between:2,255',
            'filter',
        ],
        'parent_id' => ['nullable', 'int', 'exists:categories,id'],
        'description' => ['required', 'string'],
        'art_file' => ['nullable', 'image'],
    ];

    protected $messages = [
        'image' => 'The :attribute should be an image type',
        'name.required' => 'The :attribute field is mandatory.'
    ];

    public function __construct()
    {
        $this->authorizeResource(Category::class);
    }

    // Actions
    public function index()
    {
        // if (Gate::denies('categories.view')) {
        //     abort(403);
        // }
        //$this->authorize('view-any', Category::class);
        
        //$categories = DB::table('categories')->get();
        $categories = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name',
            ])
            ->paginate();

        //$flashMessage = session('success', false);
        //$flashMessage = session()->get('success', false);
        //$flashMessage = Session::get('success', false);
        //Session::forget('success');

        return view('categories.index', [
            'categories' => $categories,
            'title' => 'Categories',
            //'flashMessage' => $flashMessage,
        ]);
    }

    public function show(Category $category)
    {
        // $category = DB::table('categories')
        //     ->where('id', '=', $id)
        //     ->first();
        
        // $category = Category::where('id', '=', $id)->firstOrFail();
        // $category = Category::findOrFail($id);
        
        // if ($category == null) {
        //     abort(404);
        // }

        return view('categories.show', [
            'category' => $category,
        ]);
    }

    public function create()
    {
        // if (Gate::denies('categories.create')) {
        //     abort(403);
        // }
        $this->authorize('create', Category::class);

        $parents = Category::all();
        $category = new Category;
        return view('categories.create', compact('category', 'parents'));
    }

    public function store(Request $request)
    {

        // if (Gate::denies('categories.create')) {
        //     abort(403);
        // }
        $this->authorize('create', Category::class);

        $clean = $request->validate($this->rules(), $this->messages);
        //dd ($clean, $request->all());
        //$clean = $this->validate($request, $rules, $messages);

        // $validator = Validator::make($request->all(), $rules, $messages);
        // //$clean = $validator->validate();
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator);
        // }

        // $clean['name']

        //     $request->name;
        //     $request->input('name');
        //     $request->post('name'); // Only post, put, patch requests
        //     $request->get('name');
        //     $request['name'];
        //     $request->query('name'); // Only query parameters

        //DB::table('categories')->insert([]);
        // $category = new Category();
        // $category->name = $request->input('name');
        // $category->description = $request->input('description');
        // $category->parent_id = $request->input('parent_id');
        // $category->slug = Str::slug($category->name);
        // $category->save();

        $data = $request->all();
        if (! $data['slug']) {
            $data['slug'] = Str::slug($data['name']);
        }

        // $category = Category::create( $data );
        dispatch(new \App\Jobs\CreateCategoryJob($data));

        // PRG: Post Redirect Get
        return redirect()
            ->route('categories.index')
            ->with('success', 'Category is being created!');

    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $this->authorize('update', $category);

        $parents = Category::all();

        //dd($parents->pluck('name', 'id')->toArray());

        return view('categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        //$category = Category::findOrFail($id);
        $this->authorize('update', $category);

        $clean = $request->validate($this->rules(), $this->messages);

        // $category->name = $request->input('name');
        // $category->description = $request->input('description');
        // $category->parent_id = $request->input('parent_id');
        // $category->slug = Str::slug($category->name);        
        // $category->save();

        $category->update($request->all());

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated!');
    }

    public function destroy($id)
    {

        $category = Category::findOrFail($id);
        $this->authorize('delete', $category);

        // DB::table('categories')->where('id', $id)->delete();
        // Category::where('id', $id)->delete();
        Category::destroy($id);

        // $category = Category::findOrFail($id);
        // $category->delete();

        //session()->flash('success', 'Category deleted!');
        //Session::flash('success', 'Category deleted!');
        //Session::put('success', 'Category deleted!');

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted!');

    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('categories.trash', [
            'categories' => $categories,
        ]);
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()
            ->route('categories.trash')
            ->with('success', 'Category restored!');

    }

    public function forceDelete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()
            ->route('categories.trash')
            ->with('success', 'Category deleted for ever!');
    }

    protected function rules()
    {
        $rules = $this->rules;

        // $rules['name'][] = function($attribute, $value, $fail) {
        //     if ($value == 'god') {
        //         $fail('This word is not allowed');
        //     }
        // };

        //$rules['name'][] = new FilterRule();

        //$rules['name'][] = 'filter';

        return $rules;
    }

}
