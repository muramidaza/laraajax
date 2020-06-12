<?php

namespace App\Http\Controllers;

use App\Act;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment;
use App\Company;
use App\Department;
use App\Person;
use App\Storefile;

class ActsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexpage($count, $id)
    {
		$retActs = Act::offset($count * ($id - 1))->limit($count)->get();
		$retCountRecords = Akt::count();
		$retData = response()->json(['equipments' => $retActs, 'countrecords' => $retCountRecords]);
		return $retData;        
    }

    public function create()
    {
 		return null;       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Akt  $akt
     * @return \Illuminate\Http\Response
     */
    public function show(Act $act)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Akt  $akt
     * @return \Illuminate\Http\Response
     */
    public function edit(Act $act)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Akt  $akt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Act $act)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Akt  $akt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Act $act)
    {
        //
    }
}
