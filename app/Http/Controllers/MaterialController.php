<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{

    private $id = 'material_id';
    private $name = 'material_name';
    private $cName = 'material';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $material = Material::all();

        return view('admin.parts.list',['id'=>$this->id,'name'=>$this->name,'objects'=>$material,'cName'=>$this->cName,'title'=>'Список матеріалів']);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.parts.create',['id'=>$this->id,'name'=>$this->name,'cName'=>$this->cName,'text'=>'Матеріал','title'=>'Додавання матеріалу']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $material = new Material();

        $material->material_name = $request->input($this->cName);
        $material->save();

        return redirect()->route($this->cName.'.create')->with('success','Матеріал Успішно Додано');

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

        $material = Material::where('material_id', $id)->first();

        return view('admin.parts.edit', ['id'=>$this->id,'name'=>$this->name,'cName'=>$this->cName,'text'=>'Матеріал','title'=>'Оновлення матеріалів','object'=>$material]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $material = Material::where('material_id', $id)->first();

        $material->material_name = $request->input($this->cName);
        $material->update();


        return redirect()->route($this->cName.'.index')->with('success','Матеріал успішно змінений');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $material = Material::where('material_id', $id)->first();
        $material->delete();

        return redirect()->route($this->cName.'.index')->with('success','Колір Видалено');

    }
}
