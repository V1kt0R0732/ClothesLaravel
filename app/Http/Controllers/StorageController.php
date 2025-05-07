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
    public function index(Request $request)
    {
        $search = '';

        if(url()->full() == url()->current()){
            session()->forget('sort'); // Очищення сесії при скиданні фільтрів
        }

        $sort = session('sort',['col'=>null,'value'=>null]);


        $storage = StorageClothes::selectRaw('*,storage_clothes.storage_cloth_id as storage_cloth_id')
            ->Leftjoin('clothes', 'storage_clothes.cloth_id', '=', 'clothes.cloth_id')
            ->join('categories', 'clothes.category_id', '=', 'categories.category_id')
            ->join('suppliers', 'clothes.supplier_id', '=', 'suppliers.supplier_id')
            ->Leftjoin('photos', 'storage_clothes.storage_cloth_id', '=', 'photos.storage_cloth_id');



        if(isset($request->search) && !empty($request->search)){
            $search = $request->search;
            $storage = $storage->where('clothes.cloth_name', 'like', '%'.$search.'%')
                ->orWhere('colors.color_name', 'like', '%'.$search.'%')
                ->orWhere('sizes.size_name', $search)
                ->orWhere('categories.category_name', 'like', '%'.$search.'%')
                ->orWhere('suppliers.supplier_name', 'like', '%'.$search.'%')
                ->orWhere('storage_clothes.count', $search);
        }
        if(isset($request->mode) && isset($request->id) && !empty($request->id) && ($request->mode == 'color' || $request->mode == 'size' || $request->mode == 'body_shape')){
            $storage = $storage->RightJoin($request->mode.'s', 'storage_clothes.'.$request->mode.'_id', '=', $request->mode.'s.'.$request->mode.'_id')
                ->where($request->mode.'s.'.$request->mode.'_id',$request->id);

            switch ($request->mode) {
                case 'color':
                    $storage = $storage->join('sizes', 'storage_clothes.size_id', '=', 'sizes.size_id')
                        ->join('body_shapes','storage_clothes.body_shape_id','=','body_shapes.body_shape_id');
                    break;
                case 'size':
                    $storage = $storage->join('colors', 'storage_clothes.color_id', '=', 'colors.color_id')
                        ->join('body_shapes','storage_clothes.body_shape_id','=','body_shapes.body_shape_id');
                    break;
                case 'body_shape':
                    $storage = $storage->join('colors', 'storage_clothes.color_id', '=', 'colors.color_id')
                        ->join('sizes', 'storage_clothes.size_id', '=', 'sizes.size_id');
            }
        }
        else{
            $storage = $storage->join('colors', 'storage_clothes.color_id', '=', 'colors.color_id')
                ->join('sizes', 'storage_clothes.size_id', '=', 'sizes.size_id')
                ->join('body_shapes','storage_clothes.body_shape_id','=','body_shapes.body_shape_id');
        }


        //Order By

        if(isset($request->col) && !empty($request->col)){
            $sort['col'] = $request->col;
        }
        if(isset($request->sort) && !empty($request->sort)){
            $sort['value'] = $request->sort;
        }
        else{
            $sort['value'] = 'asc';
        }

        if(isset($sort['col']) && !empty($sort['col'])){

            switch ($sort['col']) {
                case 'name':
                    $sort['col'] = 'clothes.cloth_name';
                    break;
                case 'id':
                    $sort['col'] = 'storage_clothes.storage_cloth_id';
                    break;
                case 'color':
                    $sort['col'] = 'storage_clothes.color_id';
                    break;
                case 'size':
                    $sort['col'] = 'storage_clothes.size_id';
                    break;
                case 'count':
                    $sort['col'] = 'storage_clothes.count';
                    break;
                case 'shape':
                    $sort['col'] = 'storage_clothes.body_shape_id';
                    break;
                case 'cat':
                    $sort['col'] = 'categories.category_id';
                    break;
                case 'sup':
                    $sort['col'] = 'suppliers.supplier_id';
                    break;
            }
            $storage = $storage->OrderBy($sort['col'],$sort['value']);
        }
        switch($sort['value']){
            case 'asc':
                $sort['value'] = 'desc';
                break;
            default:
                $sort['value'] = 'asc';
                break;
        }

        session(['sort' => $sort]);

        if(isset($request->col) && !empty($request->col)) {
            $sort['col'] = $request->col;
        }


//        switch($sort['value']){
//            case 'asc':
//                $storage = $storage->orderBy('storage_clothes.count', $sort['direction']);
//        }


        $storage = $storage->whereRaw('(photos.status = 1 or photos.status is null)')
            ->paginate(7);



        return view('admin.storage.list', compact('storage','search','sort'));
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

        return redirect()->route('storage.create', ['cloth_id' => $storage->cloth_id])->with('success','Товар успішно відредаговано');

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


        $cloth_id = StorageClothes::select('storage_clothes.cloth_id')
            ->where('storage_clothes.storage_cloth_id',$id)
            ->get()
            ->first()
            ->cloth_id;

        // Глобальна Інформація про товар
        $clothes = Clothes::join('categories','clothes.category_id','categories.category_id')
            ->join('suppliers','suppliers.supplier_id','clothes.supplier_id')
            ->where('clothes.cloth_id',$cloth_id)
            ->get()
            ->first();
        $materials = Material::join('material_clothes','material_clothes.material_id','materials.material_id')
            ->where('material_clothes.cloth_id',$cloth_id)
            ->get();
        $seasons = Season::join('season_clothes','season_clothes.season_id','seasons.season_id')
            ->where('season_clothes.cloth_id',$cloth_id)
            ->get();
        $properties = Property::where('cloth_id',$cloth_id)->get();


        $AllClothes = Clothes::select('cloth_id','cloth_name')->orderBy('cloth_name')->get();
        $AllColors = Color::all();
        $AllSizes = Size::all();
        $AllBodyShapes = BodyShape::all();

        $storage = StorageClothes::where('storage_cloth_id',$id)->get()->first();
        $photos = Photo::where('storage_cloth_id',$id)->orderBy('status', 'desc')->get();


        //print_r($photos);


        return view('admin.storage.edit', compact('storage','clothes', 'materials', 'seasons', 'properties', 'AllColors', 'AllSizes', 'AllBodyShapes','AllClothes','photos'));
        //return view('admin.storage.test');
    }

    public function photoDestroy(Request $request){


        if(isset($request->id) && !empty($request->id)){

            $photo = Photo::all()->find($request->id);
            $storage_id = $photo->storage_cloth_id;

            if($photo->status == 1){
                $photo_new = Photo::where('storage_cloth_id',$photo->storage_cloth_id)->where('status', 0)->get()->first();
                if(empty($photo_new)){
                   $photo_temp = new Photo();
                   $photo_temp->photo_name = 'images/noPhoto.png';
                   $photo_temp->status = 1;
                   $photo_temp->storage_cloth_id = $photo->storage_cloth_id;
                   $photo_temp->save();
                }
                else{
                    $photo_new->status = 1;
                    $photo_new->save();
                }
            }



            Storage::disk('public')->delete($photo->photo_name);

            $photo->delete();



            return redirect()->route('storage.edit',['storage'=>$storage_id])->with('success','Фото успішно видалено');

        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        $storage = StorageClothes::all()->find($id);


        if($request->hasFile('photo')){

            $tempPhoto = Photo::where('storage_cloth_id',$id)->get()->first();

            $tmp = true;

            if($tempPhoto->photo_name == 'images/noPhoto.png'){
                $tempPhoto->delete();
            }
            else{
                $tmp = false;
            }

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

        if(isset($request->photo_id) && !empty($request->photo_id)){
            $photo_old = Photo::where('storage_cloth_id',$id)->where('status', 1)->get()->first();
            $photo_old->status = 0;
            $photo_old->save();

            $photo_new = Photo::all()->find($request->photo_id);
            $photo_new->status = 1;
            $photo_new->save();
        }


        $storage->cloth_id = $request->get('cloth_id');
        $storage->color_id = $request->get('color_id');
        $storage->size_id = $request->get('size_id');
        $storage->count = $request->get('count');
        $storage->body_shape_id = $request->get('body_shape_id');

        $storage->update();

        return redirect()->route('storage.index')->with('success','Товар успішно додано на сайт');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $storage = StorageClothes::all()->find($id);

        // Видалення фото
        $photos = Photo::all()->where('storage_cloth_id', $id);
        foreach($photos as $photo){
            if($photo->photo_name != 'images/noPhoto.png'){
                Storage::disk('public')->delete($photo->photo_name);
            }
            $photo->delete();
        }

        $storage->delete();

        return redirect()->route('storage.index')->with('success','Товар успішно видалено');

    }
}
