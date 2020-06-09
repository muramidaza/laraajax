<?php

namespace App\Http\Controllers;

use App\Akt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment;
use App\Company;
use App\Department;
use App\Person;
use App\Storefile;

class AktsController extends Controller
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
		$retAkts = Akt::offset($count * ($id - 1))->limit($count)->get();
		$retCountRecords = Akt::count();
		$retData = response()->json(['equipments' => $retAkts, 'countrecords' => $retCountRecords]);
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
    public function show(Akt $akt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Akt  $akt
     * @return \Illuminate\Http\Response
     */
    public function edit(Akt $akt)
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
    public function update(Request $request, Akt $akt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Akt  $akt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Akt $akt)
    {
        //
    }
}
