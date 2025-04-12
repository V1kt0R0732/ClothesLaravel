<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{

    private $id = 'size_id';
    private $name = 'size_name';
    private $cName = 'size';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $size = Size::all();

        return view('admin.parts.list',['id'=>$this->id,'name'=>$this->name,'objects'=>$size,'cName'=>$this->cName,'title'=>'Список Розмірів']);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.parts.create',['id'=>$this->id,'name'=>$this->name,'cName'=>$this->cName,'text'=>'Розмір','title'=>'Додавання розмірів']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $sizeCheck = Size::where('size_name',$request->input($this->cName))->first();
        if(!empty($sizeCheck)) {
            return redirect()->route($this->cName.'.create')->with('error','Розмір вже додано');
        }
        else {
            $size = new Size();

            $size->size_name = $request->input($this->cName);
            $size->save();

            return redirect()->route($this->cName . '.create')->with('success', 'Розмір Успішно Додано');
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

        $size = Size::where('size_id', $id)->first();

        return view('admin.parts.edit', ['id'=>$this->id,'name'=>$this->name,'cName'=>$this->cName,'text'=>'Розмір','title'=>'Оновлення назви розміру','object'=>$size]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $size = Size::where('size_id', $id)->first();
        $size->size_name = $request->input($this->cName);
        $size->update();

        return redirect()->route($this->cName.'.index')->with('success','Розмір успішно змінений');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $sizeCheck = Size::where('size_id',$id)->first();

        if(!empty($sizeCheck)){
            return redirect()->route('storage.index',['id'=>$id,'mode'=>'size'])->with('error','Категорія використовується в товарах:');
        }
        else{
            $size = Size::where('size_id', $id)->first();
            $size->delete();

            return redirect()->route($this->cName.'.index')->with('success','Розмір Видалено');
        }
    }
}
