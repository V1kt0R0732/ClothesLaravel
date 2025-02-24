<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::all();

        return view('admin.categories.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if(!empty($request->input('category'))) {
            $category = new Category();

            $category->category_name = $request->input('category');
            $category->save();

            return redirect()->route('cat.create')->with('success', 'Категорія успішно створена');
        }
        else{
            return redirect()->route('cat.create')->with('error', 'Поле не може бути пустим');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $category = Category::where('category_id', $id)->first();

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $category = Category::where('category_id', $id)->first();

        $category->category_name = $request->input('category');

        $category->update();

        return redirect()->route('cat.index')->with('success','Категорія Змінена');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $category = Category::where('category_id', $id)->first();

        $category->delete();

        return redirect()->route('cat.index')->with('success','Категорія Видалена');

    }
}
