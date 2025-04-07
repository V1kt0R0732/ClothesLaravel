<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Clothes;
use App\Models\Material;
use App\Models\MaterialClothes;
use App\Models\Property;
use App\Models\Season;
use App\Models\SeasonClothes;
use App\Models\StorageClothes;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ClothesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $clothes = Clothes::selectRaw('*, (select SUM(count) from storage_clothes where storage_clothes.cloth_id = clothes.cloth_id) as storage_count')
            ->join('categories','categories.category_id','=','clothes.category_id')
            ->join('suppliers','suppliers.supplier_id','=','clothes.supplier_id')
            ->get();



        return view('admin.clothes.list', compact('clothes'));

    }

    public function adminHome(){
        return view('admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $materials = Material::all();
        $seasons = Season::all();

        return view('admin.clothes.create', compact('categories', 'suppliers', 'materials', 'seasons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        /**
         * * Розбивка на доп параметри
         */

        if($request->get('properties') !== null && $request->get('properties') != '-') {
            $prop = $request->get('properties');

            $i = 0;
            do {
                $pos = mb_strpos($prop, ':');
                $pos_2 = mb_strpos($prop, ',');

                $name = trim(mb_substr($prop, 0, $pos));
                if (isset($pos_2) && !empty($pos_2)) {
                    $value = mb_substr($prop, $pos + 1, $pos_2 - $pos - 1);
                    $prop = mb_substr($prop, $pos_2 + 1);
                } else {
                    $value = mb_substr($prop, $pos + 1);
                }
                $value = mb_ucfirst(trim($value));

                if (!empty($name) && !empty($value)) {
                    $finalProp['name'][$i] = $name;
                    $finalProp['value'][$i] = $value;
                    $i++;
                }

            } while (isset($pos_2) && !empty($pos_2));

            if (!isset($finalProp) || empty($finalProp)) {
                return redirect()->route('clothes.create')->with('Error', 'Не правильно заповнено додаткові значення');
            }
        }


        //print_r($request->all());
        $cloth = new Clothes();

        $cloth->cloth_name = $request->get('name');
        $cloth->price = $request->get('price');
        $cloth->category_id = $request->get('category_id');
        $cloth->supplier_id = $request->get('supplier_id');
        $cloth->description = $request->get('description');
        //$cloth->created_at = now(); // Для попередніх версій, при виклику id потрібно було видлити теперішній час - now()
        $cloth->save();

        foreach($request->get('materials_id') as $material){
            $material_clothes = new MaterialClothes();
            $material_clothes->material_id = $material;
            $material_clothes->cloth_id = $cloth->cloth_id;
            $material_clothes->save();
        }
        foreach($request->get('seasons_id') as $season){
            $season_clothes = new SeasonClothes();
            $season_clothes->season_id = $season;
            $season_clothes->cloth_id = $cloth->cloth_id;
            $season_clothes->save();
        }
        if($request->get('properties') !== null && $request->get('properties') != '-') {
            for ($i = 0; $i < count($finalProp['name']); $i++) {
                $property = new Property();
                $property->property_name = $finalProp['name'][$i];
                $property->property_value = $finalProp['value'][$i];
                $property->cloth_id = $cloth->cloth_id;
                $property->save();
            }
        }

        return redirect()->route('clothes.create')->with('success','Товар успішно додано');
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

        $clothes = Clothes::join('categories','clothes.category_id','categories.category_id')
            ->join('suppliers','suppliers.supplier_id','clothes.supplier_id')
            ->where('clothes.cloth_id',$id)
            ->get()
            ->first();

        $materials = Material::join('material_clothes','material_clothes.material_id','materials.material_id')
            ->where('material_clothes.cloth_id',$id)
            ->get();
        $seasons = Season::join('season_clothes','season_clothes.season_id','seasons.season_id')
            ->where('season_clothes.cloth_id',$id)
            ->get();
        $properties = Property::where('cloth_id',$id)->get();

        $AllMaterials = Material::all();
        $AllSeasons = Season::all();
        $categories = Category::all();
        $suppliers = Supplier::all();

        //print_r($clothes);

        return view('admin.clothes.edit', compact('clothes','materials', 'seasons', 'categories', 'suppliers', 'AllMaterials', 'AllSeasons', 'properties'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $cloth = Clothes::where('cloth_id',$id)->first();

        $cloth->cloth_name = $request->get('name');
        $cloth->price = $request->get('price');
        $cloth->category_id = $request->get('category_id');
        $cloth->supplier_id = $request->get('supplier_id');
        $cloth->description = $request->get('description');

        if(!empty($request->get('materials_id'))){
            $material_check = $request->get('materialCheck');
            if($material_check == 'clear'){
                $materials = MaterialClothes::where('cloth_id',$id)->get();
                foreach($materials as $material){
                    $material->delete();
                }

                foreach($request->get('materials_id') as $material_id){
                    $material = new MaterialClothes();
                    $material->material_id = $material_id;
                    $material->cloth_id = $id;
                    $material->save();
                }
            }
            elseif($material_check == 'add'){
                $old_materials_id = MaterialClothes::where('cloth_id',$id)->get();
                foreach($request->get('materials_id') as $material_id){
                    $check = true;
                    foreach($old_materials_id as $old_material_id){
                        if($material_id == $old_material_id->material_id){
                            $check = false;
                            break;
                        }
                    }
                    if($check){
                        $material = new MaterialClothes();
                        $material->material_id = $material_id;
                        $material->cloth_id = $id;
                        $material->save();
                    }
                }

            }
        }
        if(!empty($request->get('seasons_id'))){
            $season_check = $request->get('seasonCheck');
            if($season_check == 'clear'){
                $seasons = SeasonClothes::where('cloth_id',$id)->get();
                foreach($seasons as $season){
                    $season->delete();
                }
                foreach($request->get('seasons_id') as $season_id){
                    $season = new SeasonClothes();
                    $season->season_id = $season_id;
                    $season->cloth_id = $id;
                    $season->save();
                }
            }
            elseif($season_check == 'add'){
                $old_seasons_id = SeasonClothes::where('cloth_id',$id)->get();
                foreach($request->get('seasons_id') as $season_id){
                    $check = true;
                    foreach($old_seasons_id as $old_season_id){
                        if($season_id == $old_season_id->season_id){
                            $check = false;
                            break;
                        }
                    }
                    if($check){
                        $season = new SeasonClothes();
                        $season->season_id = $season_id;
                        $season->cloth_id = $id;
                        $season->save();
                    }
                }
            }
        }
        if(!empty($request->get('properties'))){
            $properties = Property::where('cloth_id',$id)->get();
            foreach($properties as $property){
                $property->delete();
            }
            if($request->get('properties') !== null && $request->get('properties') != '-') {
                $prop = $request->get('properties');

                $i = 0;
                do {
                    $pos = mb_strpos($prop, ':');
                    $pos_2 = mb_strpos($prop, ',');

                    $name = trim(mb_substr($prop, 0, $pos));
                    if (isset($pos_2) && !empty($pos_2)) {
                        $value = mb_substr($prop, $pos + 1, $pos_2 - $pos - 1);
                        $prop = mb_substr($prop, $pos_2 + 1);
                    } else {
                        $value = mb_substr($prop, $pos + 1);
                    }
                    $value = mb_ucfirst(trim($value));

                    if (!empty($name) && !empty($value)) {
                        $finalProp['name'][$i] = $name;
                        $finalProp['value'][$i] = $value;
                        $i++;
                    }

                } while (isset($pos_2) && !empty($pos_2));

                if (!isset($finalProp) || empty($finalProp)) {
                    return redirect()->route('clothes.update')->with('Error', 'Не правильно заповнено додаткові значення');
                }
            }
            if(!empty($finalProp)){
                for ($i = 0; $i < count($finalProp['name']); $i++) {
                    $property = new Property();
                    $property->property_name = $finalProp['name'][$i];
                    $property->property_value = $finalProp['value'][$i];
                    $property->cloth_id = $id;
                    $property->save();
                }
            }
        }

        $cloth->update();

        return redirect()->route('clothes.edit', $id)->with('success','Товар успішно оновлено');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
