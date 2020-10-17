<?php

namespace App\Http\Controllers\Api\V1;
	
use App\Company;
use App\Department;
use App\User;
use App\Spare;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyRequestUpdate;


class SparesController extends Controller
{
	private function StrToArrNum($str) {
		if(strlen($str) == 0) return [];
		$arr = explode(',', $str);
		$arrreturn = [];
		foreach($arr as $elem) {
			$arrreturn[] = +$elem;
		}
		return $arrreturn;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$retSpares = Spare::all();
		$retData = response()->json(['spares' => $retSpares]);
		return $retData;		
    }

    public function indexpage($count, $id, $filter)
    {
		$retOwner = null;
		if($filter == 'all') {
			$retSpares = Spare::offset($count * ($id - 1))->limit($count)->get();			
		}
		if($filter == 'new') {
			$retSpares = Spare::offset($count * ($id - 1))->limit($count)->get();			
		}		
		if($filter == 'ordered') {
			$retSpares = Spare::offset($count * ($id - 1))->limit($count)->get();			
		}
		if($filter == 'instock') {
			$retSpares = Spare::offset($count * ($id - 1))->limit($count)->get();			
		}
		if($filter == 'installed') {
			$retSpares = Spare::offset($count * ($id - 1))->limit($count)->get();			
		}		
		
		$retCountRecords = Spare::count();
		forEach($retSpares as $spare) {
			$spare->act->equipment->owner;
		};

		$retData = response()->json(['spares' => $retSpares, 'countrecords' => $retCountRecords]);
		return $retData;        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
		return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Spare  $spare
     * @return \Illuminate\Http\Response
     */
    public function show(Spare $spare)
    {
        //
		$retSpare = Company::findOrFail($id);
		$retData = response()->json(['spare' => $retSpare]);		
		return $retData;		
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Spare  $spare
     * @return \Illuminate\Http\Response
     */
    public function edit(Spare $spare)
    {
        //
		$retSpare = Company::findOrFail($id);
		$retData = response()->json(['spare' => $retSpare]);		
		return $retData;		
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Spare  $spare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Spare $spare)
    {
        //
		$spare = Spare::findOrFail($id);
		$spare->update($request->all());
		return null;		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Spare  $spare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Spare $spare)
    {
        //
		$spare = Spare::findOrFail($id);
		$spare->delete();
		return null;		
    }
}
