<?php

namespace App\Http\Controllers;

use App\Models\BodyShape;
use App\Models\StorageClothes;
use Illuminate\Http\Request;

class BodyShapeController extends Controller
{

    private $id = 'body_shape_id';
    private $name = 'body_shape_name';
    private $cName = 'bodyshape';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $objects = BodyShape::all();

        return view('admin.parts.list',['id'=>$this->id,'name'=>$this->name,'objects'=>$objects,'cName'=>$this->cName,'title'=>'Список Типів Тіла']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.parts.create',['id'=>$this->id,'name'=>$this->name,'cName'=>$this->cName,'text'=>'Тип','title'=>'Додавання Типів Тіла']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $bodyCheck = BodyShape::where('body_shape_id', $request->cName)->first();

        if(!empty($bodyCheck)){
            return redirect()->route($this->cName.'.create')->with('error','Такий тип вже додано');
        }
        else {

            $object = new BodyShape();
            $name = $this->name;
            $object->$name = $request->input($this->cName);
            $object->save();

            return redirect()->route($this->cName . '.create')->with('success', 'Тип тіла Успішно Додано');

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
        $object = BodyShape::where($this->id, $id)->first();

        return view('admin.parts.edit', ['id'=>$this->id,'name'=>$this->name,'cName'=>$this->cName,'text'=>'Форма тіла','title'=>'Оновлення назви типу тіла','object'=>$object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $object = BodyShape::where($this->id, $id)->first();
        $name = $this->name;
        $object->$name = $request->input($this->cName);
        $object->update();

        return redirect()->route($this->cName.'.index')->with('success','Тип тіла успішно змінений');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bodyCheck = StorageClothes::where('body_shape_id',$id)->first();

        if(!empty($bodyCheck)){
            return redirect()->route('storage.index',['id'=>$id,'mode'=>'body_shape'])->with('error','Вже використовується в товарах:');
        }
        else {
            $object = BodyShape::where($this->id, $id)->first();
            $object->delete();

            return redirect()->route($this->cName . '.index')->with('success', 'Тип тіла Видалено');
        }

    }
}
