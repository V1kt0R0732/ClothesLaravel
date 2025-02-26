<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private $id = 'category_id';
    private $name = 'category_name';
    private $cName = 'category';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::all();

        return view('admin.parts.list', ['id'=>$this->id,'name'=>$this->name,'objects'=>$categories,'cName'=>$this->cName,'title'=>'Список категорій']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.parts.create',['id'=>$this->id,'name'=>$this->name,'cName'=>$this->cName,'text'=>'Категорія','title'=>'Додавання категорії']);
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

            return redirect()->route('category.create')->with('success', 'Категорія успішно створена');
        }
        else{
            return redirect()->route('category.create')->with('error', 'Поле не може бути пустим');
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

        return view('admin.parts.edit', ['id'=>$this->id,'name'=>$this->name,'cName'=>$this->cName,'text'=>'Категорія','title'=>'Оновлення категорії','object'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $category = Category::where('category_id', $id)->first();

        $category->category_name = $request->input('category');

        $category->update();

        return redirect()->route('category.index')->with('success','Категорія Змінена');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $category = Category::where('category_id', $id)->first();

        $category->delete();

        return redirect()->route('category.index')->with('success','Категорія Видалена');

    }
}
