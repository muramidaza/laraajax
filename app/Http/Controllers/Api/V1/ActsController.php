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

    public function indexpage($count, $id)
    {
		$retActs = Act::offset($count * ($id - 1))->limit($count)->get();
		$retCountRecords = Akt::count();
		$retData = response()->json(['equipments' => $retActs, 'countrecords' => $retCountRecords]);
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
		
		$arrfiles = $request['Attachment'];
		
		if(!$arrfiles) return $request;
		
		foreach($arrfiles as $key => $file) {
				$orignamefile = $file->getClientOriginalName();
				$datestr = date('d_m_Y');
				$personname = $request['type'];
				$id = $act.id;
				if($request['manufacturer']) $personname = $personname.'_'.$request['manufacturer'];
				if($request['model']) $personname = $personname.'_'.$request['model'];
				if($request['modification']) $personname = $personname.'_'.$request['modification'];
				if($request['sernumber']) $personname = $personname.'_'.$request['sernumber'];
				$fileextension =  substr($orignamefile, strrpos($orignamefile, '.') + 1);
				$fullname = $key.'_'.$datestr.'_'.$personname.'_act'.$id.'.'.$fileextension;
				
				$sizefile = $file->getSize();
				$file->move('actphoto', $fullname);
				
				//$arrfiles[] = $file;
				//$img = Image::make('others/'.$fullname);
				//$img->resize(40, null, function ($constraint) {$constraint->aspectRatio();});
				//$img->save('thumbnails/'.$fullname);
				
				$recfile = new Storefile;
				$recfile->nameFile = $orignamefile;
				$recfile->pathFile = 'actsphoto/'.$fullname;
				$recfile->sizeFile = $sizefile;
				$recfile->owner()->associate($equipment);
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
		
		$retAct->users_acts_diagnos;
		$retAct->users_acts_close;
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
    public function edit(Act $act)
    {
        //
		$retAct = Act::findOrFail($id);
		
		$retAct->users_acts_diagnos;
		$retAct->users_acts_close;
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
		$act->users_act_diagnos()->sync($this->StrToArrNum($request->users_act_close));
		
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
		
		foreach($arrfiles as $key => $file) {
				$orignamefile = $file->getClientOriginalName();
				$datestr = date('d_m_Y');
				$personname = $request['type'];
				if($request['manufacturer']) $personname = $personname.'_'.$request['manufacturer'];
				if($request['model']) $personname = $personname.'_'.$request['model'];
				if($request['modification']) $personname = $personname.'_'.$request['modification'];
				if($request['sernumber']) $personname = $personname.'_'.$request['sernumber'];
				$fileextension =  substr($orignamefile, strrpos($orignamefile, '.') + 1);
				$fullname = $key.'_'.$datestr.'_'.$personname.'_act'.$id.'.'.$fileextension;
				
				$sizefile = $file->getSize();
				$file->move('actsphoto', $fullname);
				
				//$arrfiles[] = $file;
				//$img = Image::make('others/'.$fullname);
				//$img->resize(40, null, function ($constraint) {$constraint->aspectRatio();});
				//$img->save('thumbnails/'.$fullname);
				
				$recfile = new Storefile;
				$recfile->nameFile = $orignamefile;
				$recfile->pathFile = 'actsphoto/'.$fullname;
				$recfile->sizeFile = $sizefile;
				$recfile->owner()->associate($equipment);
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
