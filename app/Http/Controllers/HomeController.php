<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Clothes;
use App\Models\StorageClothes;
use App\Models\Material;
use App\Models\Season;
use App\Models\Size;
use App\Models\Color;
use App\Models\BodyShape;
use App\Models\MaterialClothes;
use App\Models\Photo;
use App\Models\SeasonClothes;
use App\Models\Property;

use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index()
    {

        $storage_ids = DB::table('clothes')->selectRaw("(select storage_clothes.storage_cloth_id from storage_clothes where storage_clothes.cloth_id = clothes.cloth_id limit 1) as storage_id")->limit(4)->inRandomOrder()->get()->pluck('storage_id');

        $clothes = StorageClothes::select('*')->join('photos', 'storage_clothes.storage_cloth_id', '=', 'photos.storage_cloth_id')
            ->join('clothes', 'storage_clothes.cloth_id', '=', 'clothes.cloth_id')
            ->join('categories', 'clothes.category_id', '=', 'categories.category_id')
            ->join('suppliers', 'clothes.supplier_id', '=', 'suppliers.supplier_id')
            ->whereIn('storage_clothes.storage_cloth_id', $storage_ids)
            ->where('photos.status', '=', 1)
            ->get();


        return view('client.index', compact('clothes'));
    }
    public function about(){
        return view('client.about');
    }
    public function contact(){
        return view('client.contact');
    }

    public function catalog(Request $request){
        $compact = [];
        // Параметр для кількості товарів на сторінці
        $countTovar = 6;





        $categories = Category::all();
        $suppliers = Supplier::all();
        $materials = Material::all();
        $seasons = Season::all();
        $sizes = Size::all();
        $colors = Color::all();
        $bodyShapes = BodyShape::all();

        // Максимальна та мінімальна ціна товарів
        $prices = [
            'max' => Clothes::max('price'),
            'min' => Clothes::min('price')
        ];


        $size_query = '';
        if($request->has('size') && !empty($request->input('size'))) {
            $selectedSize = $request->input('size');
            $compact[] = 'selectedSize';
            $size_query = " and storage_clothes.size_id = $selectedSize";
        }

        $color_query = '';
        if($request->has('color') && !empty($request->input('color'))) {
            $selectedColor = $request->input('color');
            $compact[] = 'selectedColor';
            $color_query = " and storage_clothes.color_id = $selectedColor";
        }

        $bodyShape_query = '';
        if($request->has('bodyShape') && !empty($request->input('bodyShape'))) {
            $selectedBodyShape = $request->input('bodyShape');
            $compact[] = 'selectedBodyShape';
            $bodyShape_query = " and storage_clothes.body_shape_id = $selectedBodyShape";
        }


        if ($request->has('material') && !empty($request->input('material'))) {
            $selectedMaterial = implode(',', $request->input('material'));
            $compact[] = 'selectedMaterial';

            $clothes_ids = MaterialClothes::select('cloth_id')->whereIn('material_id', $request->input('material'))->get()->pluck('cloth_id');
            // Повертаємо всі storage_cloth_id, які відповідають обраним параметрам
            $storage_ids = DB::table('clothes')->selectRaw("(select storage_clothes.storage_cloth_id from storage_clothes where storage_clothes.cloth_id = clothes.cloth_id".$size_query.$color_query.$bodyShape_query." limit 1) as storage_id")->whereIn('clothes.cloth_id', $clothes_ids)->get()->pluck('storage_id');

        }
        else {
            // Повертаємо всі storage_cloth_id, які відповідають обраним параметрам
            $storage_ids = DB::table('clothes')->selectRaw("(select storage_clothes.storage_cloth_id from storage_clothes where storage_clothes.cloth_id = clothes.cloth_id".$size_query.$color_query.$bodyShape_query." limit 1) as storage_id")->get()->pluck('storage_id');

            $selectedMaterial = null;
        }




        $clothes = StorageClothes::select('*')->join('photos', 'storage_clothes.storage_cloth_id', '=', 'photos.storage_cloth_id')
            ->join('clothes', 'storage_clothes.cloth_id', '=', 'clothes.cloth_id')
            ->join('categories', 'clothes.category_id', '=', 'categories.category_id')
            ->join('suppliers', 'clothes.supplier_id', '=', 'suppliers.supplier_id')
            ->whereIn('storage_clothes.storage_cloth_id', $storage_ids)
            ->where('photos.status', '=', 1)
        ;


        // Фільтрація за категорією
        if ($request->has('category') && !empty($request->input('category'))) {
            $selectedCategory = $request->input('category');
            $compact[] = 'selectedCategory';
            $clothes = $clothes->where('categories.category_id', '=', $selectedCategory);
        }

        // Фільтрація за постачальником
        if ($request->has('supplier') && !empty($request->input('supplier'))) {
            $selectedSupplier = $request->input('supplier');
            $compact[] = 'selectedSupplier';
            $clothes = $clothes->where('suppliers.supplier_id', '=', $selectedSupplier);
        }

        // Фільтрація за ціною
        $selectedPrice = $prices['max'];
        if ($request->has('price') && !empty($request->input('price'))) {
            $selectedPrice = $request->input('price');
            $clothes = $clothes->where('clothes.price', '<=', $selectedPrice);
        }


        // Пошук товарів за назвою
        $search = '';
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $compact[] = 'search';
            $clothes = $clothes->where('clothes.cloth_name', 'like', '%' . $search . '%')
                ->orWhere('clothes.price', 'like', '%' . $search . '%');
        }

        // Сортування товарів
        if($request->has('sort') && !empty($request->input('sort'))) {
            $sort = $request->input('sort');
            $compact[] = 'sort';
            switch ($sort) {
                case 'price_asc':
                    $clothes = $clothes->orderBy('clothes.price', 'asc');
                    break;
                case 'price_desc':
                    $clothes = $clothes->orderBy('clothes.price', 'desc');
                    break;
                case 'name_asc':
                    $clothes = $clothes->orderBy('clothes.cloth_name', 'asc');
                    break;
                case 'name_desc':
                    $clothes = $clothes->orderBy('clothes.cloth_name', 'desc');
                    break;
                default:
                    break;
            }
        }



        $clothes = $clothes->paginate($countTovar);

        $clothes->appends($request->all());


        //Загальна кількість товарів
        $totalCount = $clothes->total();




        $compact[] = ['clothes', 'categories', 'prices', 'suppliers', 'materials', 'seasons', 'sizes', 'colors', 'bodyShapes', 'totalCount', 'selectedPrice'];



        return view('client.catalog', compact($compact));

    }

    public function show($id, $photo_id){

        $clothes_main = StorageClothes::join('clothes', 'storage_clothes.cloth_id', '=', 'clothes.cloth_id')
            ->join('categories', 'clothes.category_id', '=', 'categories.category_id')
            ->join('suppliers', 'clothes.supplier_id', '=', 'suppliers.supplier_id')
            ->join('colors', 'storage_clothes.color_id', '=', 'colors.color_id')
            ->join('body_shapes', 'storage_clothes.body_shape_id', '=', 'body_shapes.body_shape_id')
            ->where('storage_clothes.storage_cloth_id', '=', $id)
            ->get()->first();
        $photos = Photo::where('storage_cloth_id', '=', $id)->get();
        $selected_photo = $photos->where('photo_id',$photo_id)->first();


        $materials = Material::join('material_clothes', 'materials.material_id', '=', 'material_clothes.material_id')
            ->where('material_clothes.cloth_id', '=', $clothes_main->cloth_id)
            ->get();
        $materials = implode(" / ", $materials->pluck('material_name')->toArray());


        $sizes_tmp = StorageClothes::select('size_id')
            ->where('cloth_id', '=', $clothes_main->cloth_id)
            ->get()->pluck('size_id')->toArray();

        $sizes_ids = Size::whereIn('size_id', $sizes_tmp)->get();


        // PS:Для майбутнього. Запит спочатку вибирає перший storage_cloth_id для кожного розміру, а потім вибирає фото для цього storage_cloth_id і всі розміри.
        $sizes = DB::table('sizes')->selectRaw("(select storage_clothes.storage_cloth_id from storage_clothes where storage_clothes.cloth_id = $clothes_main->cloth_id and storage_clothes.size_id = sizes.size_id limit 1) as storage_id, (select photo_id from photos where status = 1 and storage_cloth_id = (select storage_clothes.storage_cloth_id from storage_clothes where storage_clothes.cloth_id = $clothes_main->cloth_id and storage_clothes.size_id = sizes.size_id limit 1)) as photo_id, sizes.*")
            ->whereIn('sizes.size_id', $sizes_ids->pluck('size_id'))
            ->get();



        // Отримання кольорів, до яких відноситься цей одяг
        $colors_tmp = StorageClothes::select('color_id')
            ->where('cloth_id', '=', $clothes_main->cloth_id)
            ->where('size_id', '=', $clothes_main->size_id)
            ->get()->pluck('color_id')->toArray();

        $colors_ids = Color::whereIn('color_id', $colors_tmp)->get();

        $colors = DB::table('colors')->selectRaw("(select storage_clothes.storage_cloth_id from storage_clothes where storage_clothes.cloth_id = $clothes_main->cloth_id and storage_clothes.size_id = $clothes_main->size_id and storage_clothes.color_id = colors.color_id limit 1) as storage_id, (select photo_id from photos where status = 1 and storage_cloth_id = (select storage_clothes.storage_cloth_id from storage_clothes where storage_clothes.cloth_id = $clothes_main->cloth_id and storage_clothes.size_id = $clothes_main->size_id and storage_clothes.color_id = colors.color_id limit 1)) as photo_id, colors.*")
            ->whereIn('colors.color_id', $colors_ids->pluck('color_id'))
            ->get();

        // Отримання форми тіла, до якої відноситься цей одяг
        $body_shape_tmp = StorageClothes::select('body_shape_id')
            ->where('cloth_id', '=', $clothes_main->cloth_id)
            ->where('size_id', '=', $clothes_main->size_id)
            ->where('color_id', '=', $clothes_main->color_id)
            ->get()->pluck('body_shape_id')->toArray();

        $body_shape_ids = BodyShape::whereIn('body_shape_id', $body_shape_tmp)->get();

        $body_shapes = DB::table('body_shapes')->selectRaw("(select storage_clothes.storage_cloth_id from storage_clothes where storage_clothes.cloth_id = $clothes_main->cloth_id and storage_clothes.size_id = $clothes_main->size_id and storage_clothes.color_id = $clothes_main->color_id and storage_clothes.body_shape_id = body_shapes.body_shape_id limit 1) as storage_id, (select photo_id from photos where status = 1 and storage_cloth_id = (select storage_clothes.storage_cloth_id from storage_clothes where storage_clothes.cloth_id = $clothes_main->cloth_id and storage_clothes.size_id = $clothes_main->size_id and storage_clothes.color_id = $clothes_main->color_id and storage_clothes.body_shape_id = body_shapes.body_shape_id limit 1)) as photo_id, body_shapes.*")
            ->whereIn('body_shapes.body_shape_id', $body_shape_ids->pluck('body_shape_id'))
            ->get();


        // Отримання сезонів, до яких відноситься цей одяг
        $seasons = Season::join('season_clothes', 'seasons.season_id', '=', 'season_clothes.season_id')
            ->where('season_clothes.cloth_id', '=', $clothes_main->cloth_id)
            ->get();
        $seasons = implode(" / ", $seasons->pluck('season_name')->toArray());


        $properties = Property::where('cloth_id', '=', $clothes_main->cloth_id)->get();

        //dd($properties);

        return view('client.show', compact( 'clothes_main', 'photos', 'selected_photo','materials','sizes','seasons','properties','colors', 'body_shapes'));
    }


}
