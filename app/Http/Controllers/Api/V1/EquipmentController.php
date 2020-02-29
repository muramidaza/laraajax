<?php

namespace App\Http\Controllers\Api\V1;

use App\Equipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use App\Department;
use App\People;
use App\Storefile;

class EquipmentController extends Controller
{

    public function index()
    {
		$retEquipments = Equipment::all();
		$retData = response()->json(['equipments' => $retEquipments]);
		return $retData;        
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show(Equipment $equipment)
    {
        
    }

    public function edit(Equipment $equipment)
    {
        
    }

    public function update(Request $request, Equipment $equipment)
    {
        
    }

    public function destroy(Equipment $equipment)
    {
        
    }
}
