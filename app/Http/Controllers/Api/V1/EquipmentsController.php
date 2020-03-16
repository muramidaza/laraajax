<?php

namespace App\Http\Controllers\Api\V1;

use App\Equipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use App\Department;
use App\Person;
use App\Storefile;

class EquipmentsController extends Controller
{

    public function index()
    {
		$retEquipments = Equipment::all();
		$retData = response()->json(['equipments' => $retEquipments]);
		return $retData;        
    }

    public function create()
    {
 		return null;       
    }

    public function store(Request $request)
    {
		
		$equipment = new Equipment;
		$equipment->fill($request->all());
		$equipment->save();
		if($request['company']) $equipment->owner()->associate(Company::findOrFail($request['company']))->save();
		if($request['department']) $equipment->owner()->associate(Department::findOrFail($request['department']))->save();	
		if($request['person']) $equipment->owner()->associate(Person::findOrFail($request['person']))->save();
		
		$arrfiles = $request['Attachment'];
		
		if(!$arrfiles) return $request;
		
		foreach($arrfiles as $key => $file) {
				$orignamefile = $file->getClientOriginalName();
				$datestr = date('d_m_Y');
				$personname = $request['type'];
				if($request['manufacturer']) $personname = $personname.'_'.$request['manufacturer'];
				if($request['model']) $personname = $personname.'_'.$request['model'];
				if($request['modification']) $personname = $personname.'_'.$request['modification'];
				if($request['sernumber']) $personname = $personname.'_'.$request['sernumber'];
				$fileextension =  substr($orignamefile, strrpos($orignamefile, '.') + 1);
				$fullname = $key.'_'.$datestr.'_'.$personname.'.'.$fileextension;
				
				$sizefile = $file->getSize();
				$file->move('equipments', $fullname);
				
				//$arrfiles[] = $file;
				//$img = Image::make('others/'.$fullname);
				//$img->resize(40, null, function ($constraint) {$constraint->aspectRatio();});
				//$img->save('thumbnails/'.$fullname);
				
				$recfile = new Storefile;
				$recfile->nameFile = $orignamefile;
				$recfile->pathFile = 'equipments/'.$fullname;
				$recfile->sizeFile = $sizefile;
				$recfile->owner()->associate($equipment);
				$recfile->save();
			}
			
		return null;        
    }

    public function show(Equipment $equipment)
    {
        
    }

    public function edit($id)
    {
		$equipment = Equipment::findOrFail($id);
		
		$equipment->owner->id;
		if((string)$equipment->owner_type == 'App\Department') $equipment->owner->company->name;
		$equipment->files;
		
		//if(count($equipment->departments) > 0) $equipment->departments->first()->company;
				
		$retData = response()->json(['equipment' => $equipment]);
		
		return $retData;

    }

    public function update(Request $request, $id)
    {

		$equipment = Equipment::findOrFail($id);
		$equipment->fill($request->all());
		$equipment->save();
		if($request['company']) $equipment->owner()->associate(Company::findOrFail($request['company']))->save();
		if($request['department']) $equipment->owner()->associate(Department::findOrFail($request['department']))->save();	
		if($request['person']) $equipment->owner()->associate(Person::findOrFail($request['person']))->save();	
	
		$strDeleteFiles = $request['delfiles'];
		
 		if($strDeleteFiles) {
			$arrDeleteFiles = explode(',', $strDeleteFiles);
			
			foreach($arrDeleteFiles as $delFileID) {
				$delfile = Storefile::findOrFail($delFileID);
				unlink($delfile->pathFile);
				$delfile->delete();
			}		
		}	
	
		$arrfiles = $request['Attachment'];
		
		if(!$arrfiles) return $request;
		
		foreach($arrfiles as $key => $file) {
				$orignamefile = $file->getClientOriginalName();
				$datestr = date('d_m_Y');
				$personname = $request['type'];
				if($request['manufacturer']) $personname = $personname.'_'.$request['manufacturer'];
				if($request['model']) $personname = $personname.'_'.$request['model'];
				if($request['modification']) $personname = $personname.'_'.$request['modification'];
				if($request['sernumber']) $personname = $personname.'_'.$request['sernumber'];
				$fileextension =  substr($orignamefile, strrpos($orignamefile, '.') + 1);
				$fullname = $key.'_'.$datestr.'_'.$personname.'.'.$fileextension;
				
				$sizefile = $file->getSize();
				$file->move('equipments', $fullname);
				
				//$arrfiles[] = $file;
				//$img = Image::make('others/'.$fullname);
				//$img->resize(40, null, function ($constraint) {$constraint->aspectRatio();});
				//$img->save('thumbnails/'.$fullname);
				
				$recfile = new Storefile;
				$recfile->nameFile = $orignamefile;
				$recfile->pathFile = 'equipments/'.$fullname;
				$recfile->sizeFile = $sizefile;
				$recfile->owner()->associate($equipment);
				$recfile->save();
			}
			
		return null;	        
    }

    public function destroy($id)
    {
		$equipment = Equipment::findOrFail($id);
		$equipment->delete();
		return null;        
    }
}
