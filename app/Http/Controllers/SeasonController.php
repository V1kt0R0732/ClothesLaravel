<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\SeasonClothes;
use Illuminate\Http\Request;

class SeasonController extends Controller
{

    private $id = 'season_id';
    private $name = 'season_name';
    private $cName = 'season';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $season = Season::all();

        return view('admin.parts.list',['id'=>$this->id,'name'=>$this->name,'objects'=>$season,'cName'=>$this->cName,'title'=>'Список Сезонів']);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.parts.create',['id'=>$this->id,'name'=>$this->name,'cName'=>$this->cName,'text'=>'Сезон','title'=>'Додавання сезону']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $seasonCheck = Season::where('season_name',$request->input('season'))->first();

        if(!empty($seasonCheck)){
            return redirect()->route($this->cName.'.create')->with('error',"Товар з таким ім'ям вже існує");
        }
        else{
            $season = new Season();
            $season->season_name = $request->input($this->cName);
            $season->save();

            return redirect()->route($this->cName.'.create')->with('success','Сезон Успішно Додано');
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

        $season = Season::where('season_id', $id)->first();

        return view('admin.parts.edit', ['id'=>$this->id,'name'=>$this->name,'cName'=>$this->cName,'text'=>'Сезон','title'=>'Оновлення назви сезону','object'=>$season]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $season = Season::where('season_id', $id)->first();

        $season->season_name = $request->input($this->cName);
        $season->update();

        return redirect()->route($this->cName.'.index')->with('success','Сезон успішно змінений');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $seasonCheck = SeasonClothes::where('season_id',$id)->first();

        if(!empty($seasonCheck)){
            return redirect()->route('clothes.index',['id'=>$id,'mode'=>'season'])->with('error','Даний сезон вже використовується в товарах:');
        }

        $season = Season::where('season_id', $id)->first();
        $season->delete();

        return redirect()->route($this->cName.'.index')->with('success','Сезон Видалено');

    }
}
