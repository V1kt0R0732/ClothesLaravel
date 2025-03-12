<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{

    private $id = 'property_id';
    private $name = 'supplier_name';
    private $cName = 'supplier';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $objects = Property::all();

        return view('admin.parts.list',['id'=>$this->id,'name'=>$this->name,'objects'=>$objects,'cName'=>$this->cName,'title'=>'Список Постачальників']);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
