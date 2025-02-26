<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{

    private $id = 'color_id';
    private $name = 'color_name';
    private $cName = 'color';


    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $colors = Color::all();

        return view('admin.parts.list',['id'=>$this->id,'name'=>$this->name,'objects'=>$colors,'cName'=>$this->cName,'title'=>'Список кольорів']);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.parts.create',['id'=>$this->id,'name'=>$this->name,'cName'=>$this->cName,'text'=>'Колір','title'=>'Додавання кольору']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $color = new Color();

        $color->color_name = $request->input($this->cName);
        $color->save();

        return redirect()->route('color.create')->with('success','Колір Успішно додано');

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

        $color = Color::where('color_id', $id)->first();

        return view('admin.parts.edit', ['id'=>$this->id,'name'=>$this->name,'cName'=>$this->cName,'text'=>'Колір','title'=>'Оновлення кольорів','object'=>$color]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $color = Color::where('color_id', $id)->first();

        $color->color_name = $request->input($this->cName);

        $color->update();

        return redirect()->route($this->cName.'.index')->with('success','Колір успішно змінений');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $color = Color::where('color_id', $id)->first();

        $color->delete();

        return redirect()->route($this->cName.'.index')->with('success','Колір Видалено');
    }
}
