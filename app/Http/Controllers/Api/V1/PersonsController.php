<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;
use App\Department;
use App\Person;
use App\Storefile;

use App\Http\Requests\PersonRequest;
use App\Http\Requests\PersonRequestUpdate;

class PersonsController extends Controller
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
	
	public function index()
	{
		$retPersons = Person::all();

		//$retPersons->each(function($person) {$person->departments;});
		//$retPersons->each(function($person) {$person->companies;});		
		
		$retData = response()->json(['persons' => $retPersons]);
		return $retData;
	}
	
	public function create()
	{
		return null;
	}
	
	public function show($id)
	{
		$retPerson = Person::findOrFail($id);
		
		$retPerson->companies;
		$retPerson->departments;
		$retPerson->files;
		if(count($retPerson->departments) > 0) $retPerson->departments->first()->company;

		$retData = response()->json(['person' => $retPerson]);
		
		return $retData;
	}

	public function edit($id)
	{

		$retPerson = Person::findOrFail($id);
		
		$retPerson->companies;
		$retPerson->departments;
		$retPerson->files;
		
		if(count($retPerson->departments) > 0) $retPerson->departments->first()->company;
				
		$retData = response()->json(['person' => $retPerson]);
		
		return $retData;
	}	
	
	public function update(PersonRequestUpdate $request, $id)
	{
		$person = Person::findOrFail($id);
		$person->fill($request->except(['companies', 'departments', 'files']));
		$person->save();
		
		$person->companies()->sync($this->StrToArrNum($request->companies));
		$person->departments()->sync($this->StrToArrNum($request->departments));
		
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
				$personname = $request['name'];
				if($request['surname']) $personname = $personname.'_'.$request['surname'];
				if($request['patronymic']) $personname = $personname.'_'.$request['patronymic'];
				$fileextension =  substr($orignamefile, strrpos($orignamefile, '.') + 1);
				$fullname = $key.'_'.$datestr.'_'.$personname.'.'.$fileextension;
				
				$sizefile = $file->getSize();
				$typeFile = $file->getMimeType();
				$file->move('persons', $fullname);
				
				//$arrfiles[] = $file;
				//$img = Image::make('others/'.$fullname);
				//$img->resize(40, null, function ($constraint) {$constraint->aspectRatio();});
				//$img->save('thumbnails/'.$fullname);
				
				$recfile = new Storefile;
				$recfile->nameFile = $orignamefile;
				$recfile->pathFile = 'persons/'.$fullname;
				$recfile->sizeFile = $sizefile;
				$recfile->typeFile = $typeFile;
				$recfile->owner()->associate($person);
				$recfile->save();
			}
		
		return null;
	}
	
	public function store(PersonRequest $request)
	{
		
		$person = new Person;
		$person->fill($request->except(['companies', 'departments']));
		$person->save();
		$person->companies()->sync($this->StrToArrNum($request->companies));
		$person->departments()->sync($this->StrToArrNum($request->departments));
		
		$arrfiles = $request['Attachment'];
		
		if(!$arrfiles) return $request;
		
		foreach($arrfiles as $key => $file) {
				$orignamefile = $file->getClientOriginalName();
				$datestr = date('d_m_Y');
				$personname = $request['name'];
				if($request['surname']) $personname = $personname.'_'.$request['surname'];
				if($request['patronymic']) $personname = $personname.'_'.$request['patronymic'];
				$fileextension =  substr($orignamefile, strrpos($orignamefile, '.') + 1);
				$fullname = $key.'_'.$datestr.'_'.$personname.'.'.$fileextension;
				
				$sizefile = $file->getSize();
				$typeFile = $file->getMimeType();
				
				$file->move('persons', $fullname);
				
				//$arrfiles[] = $file;
				//$img = Image::make('others/'.$fullname);
				//$img->resize(40, null, function ($constraint) {$constraint->aspectRatio();});
				//$img->save('thumbnails/'.$fullname);
				
				$recfile = new Storefile;
				$recfile->nameFile = $orignamefile;
				$recfile->pathFile = 'persons/'.$fullname;
				$recfile->sizeFile = $sizefile;
				$recfile->typeFile = $typeFile;
				$recfile->owner()->associate($person);
				$recfile->save();
			}
			
		return null;
	}
	
	public function destroy($id)
	{
		$person = Person::findOrFail($id);
		$person->delete();
		return null;
	}	
}
