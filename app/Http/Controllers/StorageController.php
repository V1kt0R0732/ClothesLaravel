<?php

namespace App\Http\Controllers;

use App\Models\Clothes;
use App\Models\Color;
use App\Models\Property;
use App\Models\Size;
use App\Models\BodyShape;
use App\Models\StorageClothes;
use App\Models\Photo;
use App\Models\Material;
use App\Models\Season;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $storage = StorageClothes::join('colors', 'storage_clothes.color_id', '=', 'colors.color_id')
            ->join('sizes', 'storage_clothes.size_id', '=', 'sizes.size_id')
            ->Leftjoin('clothes', 'storage_clothes.cloth_id', '=', 'clothes.cloth_id')
            ->join('categories', 'clothes.category_id', '=', 'categories.category_id')
            ->join('suppliers', 'clothes.supplier_id', '=', 'suppliers.supplier_id')
            ->Leftjoin('photos', 'storage_clothes.storage_cloth_id', '=', 'photos.storage_cloth_id')
            ->where('photos.status', '=', 1)
            ->orWhere('photos.status', '=', null)
//            ->Leftjoin('season_clothes', 'clothes.cloth_id', '=', 'season_clothes.cloth_id')
//            ->join('seasons', 'season_clothes.season_id', '=', 'seasons.season_id')
//            ->join('properties', 'clothes.cloth_id', '=', 'properties.cloth_id')
//            ->join('material_clothes','clothes.cloth_id','=','material_clothes.cloth_id')
//            ->join('materials', 'material_clothes.material_id', '=', 'materials.material_id')
            ->get();

//        $url = Storage::path($storage[0]->photo_name);
//        $url_2 = Storage::path($storage[0]->photo_name);
//        print_r($url_2);
//        echo "<br>";
//        print_r($url);

        //print_r($storage);


        return view('admin.storage.index', compact('storage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {


        //$clothes = Clothes::select('cloth_id','cloth_name')->get();
        $clothes = Clothes::join('categories','clothes.category_id','categories.category_id')
            ->join('suppliers','suppliers.supplier_id','clothes.supplier_id')
            ->where('clothes.cloth_id',$request->get('cloth_id'))
            ->get()
            ->first();
        $materials = Material::join('material_clothes','material_clothes.material_id','materials.material_id')
            ->where('material_clothes.cloth_id',$request->get('cloth_id'))
            ->get();
        $seasons = Season::join('season_clothes','season_clothes.season_id','seasons.season_id')
            ->where('season_clothes.cloth_id',$request->get('cloth_id'))
            ->get();
        $properties = Property::where('cloth_id',$request->get('cloth_id'))->get();


        $colors = Color::all();
        $sizes = Size::all();
        $bodyShapes = BodyShape::all();

        return view('admin.storage.create', compact('clothes', 'materials', 'seasons', 'properties', 'colors', 'sizes', 'bodyShapes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $storage = new StorageClothes();
        $storage->cloth_id = $request->get('cloth_id');
        $storage->color_id = $request->get('color_id');
        $storage->size_id = $request->get('size_id');
        $storage->count = $request->get('count');
        $storage->body_shape_id = $request->get('body_shape_id');
        $storage->save();

        if($request->hasFile('photo')){
            $tmp = true;
            foreach($request->file('photo') as $file){
                $photo = new Photo();

                $photo->photo_name = $file->store('images','public');
                $photo->storage_cloth_id = $storage->storage_cloth_id;
                if($tmp){
                    $photo->status = 1;
                    $tmp = false;
                }
                $photo->save();
            }
        }
        else{
            $photo = new Photo();

            $photo->photo_name = 'images/noPhoto.png';
            $photo->storage_cloth_id = $storage->storage_cloth_id;
            $photo->status = 1;
            $photo->save();
        }

        return redirect()->route('storage.create', ['cloth_id' => $storage->cloth_id])->with('success','Товар успішно додано на сайт');

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
//        $clothes = Clothes::join('categories','clothes.category_id','categories.category_id')
//            ->join('suppliers','suppliers.supplier_id','clothes.supplier_id')
//            ->where('clothes.cloth_id',$request->get('cloth_id'))
//            ->get();
//        $materials = Material::join('material_clothes','material_clothes.material_id','materials.material_id')
//            ->where('material_clothes.cloth_id',$request->get('cloth_id'))
//            ->get();
//        $seasons = Season::join('season_clothes','season_clothes.season_id','seasons.season_id')
//            ->where('season_clothes.cloth_id',$request->get('cloth_id'))
//            ->get();
//        $properties = Property::where('cloth_id',$request->get('cloth_id'))->get();
//
//        $colors = Color::all();
//        $sizes = Size::all();
//        $bodyShapes = BodyShape::all();
//
//
//        return view('admin.storage.edit', compact('storage'));
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
