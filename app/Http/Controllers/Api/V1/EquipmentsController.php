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

    public function indexpage($count, $id, $refertype, $referid)
    {
		
		$retOwner = null;
		if($refertype == 'none') {
			$retEquipments = Equipment::offset($count * ($id - 1))->limit($count)->get(); 
			$retCountRecords = Equipment::count();
		}
		if($refertype == 'company') {
			$retEquipments = Company::findOrFail($referid)->Equipments()->offset($count * ($id - 1))->limit($count)->get();
			$retCountRecords = Company::findOrFail($referid)->Equipments->count();
			$retOwner = Company::findOrFail($referid);
		}
		if($refertype == 'department') {
			$retEquipments = Department::findOrFail($referid)->Equipments()->offset($count * ($id - 1))->limit($count)->get();
			$retCountRecords = Department::findOrFail($referid)->Equipments->count();
			$retOwner = Department::findOrFail($referid);
		}
		if($refertype == 'person') {
			$retEquipments = Person::findOrFail($referid)->Equipments()->offset($count * ($id - 1))->limit($count)->get();
			$retCountRecords = Person::findOrFail($referid)->Equipments->count();
			$retOwner = Person::findOrFail($referid);
		}		
		
	
		forEach($retEquipments as $equipment) {
			$equipment->acts;
		};
		
		$retData = response()->json(['equipments' => $retEquipments, 'countrecords' => $retCountRecords, 'owner' => $retOwner]);
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
				$equipname = $request['type'];
				if($request['manufacturer']) $equipname = $equipname.'_'.$request['manufacturer'];
				if($request['model']) $equipname = $equipname.'_'.$request['model'];
				if($request['modification']) $equipname = $equipname.'_'.$request['modification'];
				if($request['sernumber']) $equipname = $equipname.'_'.$request['sernumber'];
				$fileextension =  substr($orignamefile, strrpos($orignamefile, '.') + 1);
				$fullname = $key.'_'.$datestr.'_'.$equipname.'.'.$fileextension;
				
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

    public function show($id)
    {
		$equipment = Equipment::findOrFail($id);
		
		$equipment->owner->id;
		if((string)$equipment->owner_type == 'App\Department') $equipment->owner->company->id;
		$equipment->files;
		
		//if(count($equipment->departments) > 0) $equipment->departments->first()->company;
				
		$retData = response()->json(['equipment' => $equipment]);
		
		return $retData;        
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
				$equipname = $request['type'];
				if($request['manufacturer']) $equipname = $equipname.'_'.$request['manufacturer'];
				if($request['model']) $equipname = $equipname.'_'.$request['model'];
				if($request['modification']) $equipname = $equipname.'_'.$request['modification'];
				if($request['sernumber']) $equipname = $equipname.'_'.$request['sernumber'];
				$fileextension =  substr($orignamefile, strrpos($orignamefile, '.') + 1);
				$fullname = $key.'_'.$datestr.'_'.$equipname.'.'.$fileextension;
				
				$sizefile = $file->getSize();
				$typefile = $file->getMimeType();
				
				$file->move('equipments', $fullname);
				
				//$arrfiles[] = $file;
				//$img = Image::make('others/'.$fullname);
				//$img->resize(40, null, function ($constraint) {$constraint->aspectRatio();});
				//$img->save('thumbnails/'.$fullname);
				
				$recfile = new Storefile;
				$recfile->nameFile = $orignamefile;
				$recfile->pathFile = 'equipments/'.$fullname;
				$recfile->sizeFile = $sizefile;
				$recfile->typeFile = $typefile;
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
