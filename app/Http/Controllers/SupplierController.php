<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Clothes;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    private $id = 'supplier_id';
    private $name = 'supplier_name';
    private $cName = 'supplier';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $objects = Supplier::all();

        return view('admin.parts.list',['id'=>$this->id,'name'=>$this->name,'objects'=>$objects,'cName'=>$this->cName,'title'=>'Список країни Виробника']);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.parts.create',['id'=>$this->id,'name'=>$this->name,'cName'=>$this->cName,'text'=>'Країна','title'=>'Додавання Країна виробник']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if(!empty($request->input('supplier'))) {
            $supplierCheck = Supplier::where('supplier_name', $request->input($this->cName))->first();

            if(!empty($supplierCheck)){
                return redirect()->route($this->cName . '.create')->with('error','Такий поставщик вже доданий');
            }
            else {
                $object = new Supplier();
                $name = $this->name;
                $object->$name = $request->input($this->cName);
                $object->save();

                return redirect()->route($this->cName . '.create')->with('success', 'Країна виробник Успішно Додано');
            }
        }
        else{
            return redirect()->route($this->cName . '.create')->with('error','Поле не може бути пустим');
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
        $object = Supplier::where($this->id, $id)->first();

        return view('admin.parts.edit', ['id'=>$this->id,'name'=>$this->name,'cName'=>$this->cName,'text'=>'Розмір','title'=>'Оновлення назви країни виробник','object'=>$object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $object = Supplier::where($this->id, $id)->first();
        $name = $this->name;
        $object->$name = $request->input($this->cName);
        $object->update();

        return redirect()->route($this->cName.'.index')->with('success','Країна виробник успішно змінена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplierCheck = Clothes::where('supplier_id',$id)->first();

        if(!empty($supplierCheck)){
            return redirect()->route('clothes.index',['id'=>$id,'mode'=>'supplier'])->with('error','Товар з такою країною використовується');
        }

        $object = Supplier::where($this->id, $id)->first();
        $object->delete();

        return redirect()->route($this->cName.'.index')->with('success','Країна виробник Видалена');

    }
}
