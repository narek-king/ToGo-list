<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Places;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Examples\Tables\Builders\PlaceTable;

use LaravelEnso\VueDatatable\app\Traits\Datatable;


class PlacesController extends Controller
{
    use Datatable;

    protected $tableClass = PlaceTable::class;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function data(Request $request)
    {
    }

    public function init()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Places
     */
    public function index()
    {
        return Places::where('user_id', Auth::id())->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $place = Places::create($data);
        return $place;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place = Places::findOrFail($id);
        if ($place->user_id == Auth::id())
            return $place;
        return response()->json(['message' => 'unauthorised'], 401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $place = Places::findOrFail($id);
        if ($place->user_id == Auth::id()){
            $place->update($request->all());
            return $place;
        }
        return response()->json(['message' => 'unauthorised'], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place = Places::findOrFail($id);
        if ($place->user_id == Auth::id()) {
            $place->delete();
            return '';
        }
        return response()->json(['message' => 'unauthorised'], 401);
    }
}
