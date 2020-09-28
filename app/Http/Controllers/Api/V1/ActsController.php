<?php

namespace App\Http\Controllers\Api\V1;

use App\Act;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Equipment;
use App\Company;
use App\Department;
use App\Person;
use App\Storefile;
use App\Spare;

class ActsController extends Controller
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

	private function objectToArray($obj) {
		$arr = [];
		foreach ($obj as $key => $val) {
			$arr[$key] = $val;
		}
		return $arr;
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		return null;  
    }

    public function indexpage($count, $id, $refertype, $referid)
    {
		$retOwner = null;
		if($refertype == 'none') {
			$retActs = Act::offset($count * ($id - 1))->limit($count)->get(); 
			$retCountRecords = Act::count();
		}
		if($refertype == 'company') {
			$retActs = Company::findOrFail($referid)->Acts()->offset($count * ($id - 1))->limit($count)->get();
			$retCountRecords = Company::findOrFail($referid)->Acts->count();
			$retOwner = Company::findOrFail($referid);
		}
		if($refertype == 'department') {
			$retActs = Department::findOrFail($referid)->Acts()->offset($count * ($id - 1))->limit($count)->get();
			$retCountRecords = Department::findOrFail($referid)->Acts->count();
			$retOwner = Department::findOrFail($referid);
		}
		if($refertype == 'person') {
			$retActs = Person::findOrFail($referid)->Acts()->offset($count * ($id - 1))->limit($count)->get();
			$retCountRecords = Person::findOrFail($referid)->Acts->count();
			$retOwner = Person::findOrFail($referid);
		}
		if($refertype == 'equipment') {
			$retActs = Equipment::findOrFail($referid)->Acts()->offset($count * ($id - 1))->limit($count)->get();
			$retCountRecords = Equipment::findOrFail($referid)->Acts->count();
			$retOwner = Equipment::findOrFail($referid);
		}
		
		forEach($retActs as $act) {
			$act->equipment;
			$act->equipment->owner;
			if((string)$act->equipment->owner_type == 'App\Department') $act->equipment->owner->company;
		};

		$retData = response()->json(['acts' => $retActs, 'countrecords' => $retCountRecords, 'owner' => $retOwner]);
		return $retData;        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
		$act = new Act;
		$act->fill($request->except(['users_acts_diagnos', 'users_acts_close', 'files']));
		$act->save();
		$act->users_act_diagnos()->sync($this->StrToArrNum($request->users_act_diagnos));
		$act->users_act_close()->sync($this->StrToArrNum($request->users_act_close));
		
		$equipment = Equipment::findOrFail($request['equipment_id']);
		$owner = $equipment->owner;
		$act->owner()->associate($owner)->save();

		$arrspares = $request['Spares'];
		
		if($arrspares) {
			foreach($arrspares as $key => $jsonspare) {
				$sparearr = $this->objectToArray(json_decode($jsonspare));
				$spare = new Spare;
				$spare->fill($sparearr);
				$spare->act()->associate($act);
				$spare->save();
			}
		};
		
		$arrfiles = $request['Attachment'];
		
		if(!$arrfiles) return $equipment->owner;
		
		foreach($arrfiles as $key => $file) {
				$orignamefile = $file->getClientOriginalName();
				$datestr = date('d_m_Y');
				
				$id = $act->id;
				
				$equipname = $equipment->type;
				if($equipment->manufacturer) $equipname = $equipname.'_'.($equipment->manufacturer);
				if($equipment->model) $equipname = $equipname.'_'.($equipment->model);
				if($equipment->modification) $equipname = $equipname.'_'.($equipment->modification);
				if($equipment->sernumber) $equipname = $equipname.'_'.($equipment->sernumber);
				$fileextension =  substr($orignamefile, strrpos($orignamefile, '.') + 1);
				$fullname = $key.'_'.$datestr.'_'.$equipname.'_act'.$id.'.'.$fileextension;
				
				$sizefile = $file->getSize();
				$typefile = $file->getMimeType();
				
				$file->move('acts', $fullname);
				
				//$arrfiles[] = $file;
				//$img = Image::make('others/'.$fullname);
				//$img->resize(40, null, function ($constraint) {$constraint->aspectRatio();});
				//$img->save('thumbnails/'.$fullname);
				
				
				$recfile = new Storefile;
				$recfile->nameFile = $orignamefile;
				$recfile->pathFile = 'acts/'.$fullname;
				$recfile->sizeFile = $sizefile;
				$recfile->typeFile = $typefile;
				$recfile->owner()->associate($act);
				$recfile->save();
			}
			
		return null;
		
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
		$retAct = Act::findOrFail($id);
		
		$retAct->users_act_diagnos;
		$retAct->users_act_close;
		$retAct->files;
		
		$retData = response()->json(['act' => $retAct]);
		
		return $retData;		
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Akt  $akt
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
		$retAct = Act::findOrFail($id);
		
		$retAct->users_act_diagnos;
		$retAct->users_act_close;
		$retAct->files;
		
		$retData = response()->json(['act' => $retAct]);
		
		return $retData;		
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Akt  $akt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
		$act = Act::findOrFail($id);
		$act->fill($request->except(['users_acts_diagnos', 'users_acts_close', 'files']));
		$act->save();
		
		$act->users_act_diagnos()->sync($this->StrToArrNum($request->users_act_diagnos));
		$act->users_act_close()->sync($this->StrToArrNum($request->users_act_close));
		
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
		if(!$arrfiles) return null;
		
		$equipment = Equipment::findOrFail($request['equipment_id']);
		
		foreach($arrfiles as $key => $file) {
				$orignamefile = $file->getClientOriginalName();
				$datestr = date('d_m_Y');

				$equipname = $equipment->type;
				if($equipment->manufacturer) $equipname = $equipname.'_'.($equipment->manufacturer);
				if($equipment->model) $equipname = $equipname.'_'.($equipment->model);
				if($equipment->modification) $equipname = $equipname.'_'.($equipment->modification);
				if($equipment->sernumber) $equipname = $equipname.'_'.($equipment->sernumber);
				$fileextension =  substr($orignamefile, strrpos($orignamefile, '.') + 1);
				$fullname = $key.'_'.$datestr.'_'.$equipname.'_act'.$id.'.'.$fileextension;
				
				$sizefile = $file->getSize();
				$typefile = $file->getMimeType();
				
				$file->move('acts', $fullname);
				
				//$arrfiles[] = $file;
				//$img = Image::make('others/'.$fullname);
				//$img->resize(40, null, function ($constraint) {$constraint->aspectRatio();});
				//$img->save('thumbnails/'.$fullname);
				
				
				$recfile = new Storefile;
				$recfile->nameFile = $orignamefile;
				$recfile->pathFile = 'acts/'.$fullname;
				$recfile->sizeFile = $sizefile;
				$recfile->typeFile = $typefile;
				$recfile->owner()->associate($act);
				$recfile->save();
			}
		
		return null;
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
		$act = Act::findOrFail($id);
		$act->delete();
		return null;		
    }
}
