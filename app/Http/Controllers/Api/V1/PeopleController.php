<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;
use App\Department;
use App\People;
use App\Storefile;

use App\Http\Requests\PeopleRequest;
use App\Http\Requests\PeopleRequestUpdate;

class PeopleController extends Controller
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
		$retPeople = People::all();
		$retData = response()->json(['people' => $retPeople]);
		return $retData;
	}
	
	public function create()
	{
		$retCompanies = Company::all();
		$retDepartments = Department::all();
		$retData = response()->json(['companies' => $retCompanies, 'departments' => $retDepartments]);
		return $retData;
	}
	
	public function show($id)
	{
		$retOnePeople = People::findOrFail($id);
		
		$retRelCompanies = $retOnePeople->companies;
		$retRelDepartments = $retOnePeople->departments;
		$retFilesData = $retOnePeople->files;

		$retData = response()->json(['onepeople' => $retOnePeople, 'relcompanies' => $retRelCompanies, 'reldepartments' => $retRelDepartments, 'filesdata' => $retFilesData]);
		
		return $retData;
	}

	public function edit($id)
	{
		function dataToArrID($data) {
			$arr = [];
			foreach($data->toArray() as $elem) {
				$arr[] = $elem['id'];
			}
			return $arr;
		}
		
		$retOnePeople = People::findOrFail($id);
		
		$retRelCompanies = $retOnePeople->companies;
		$retRelDepartments = $retOnePeople->departments;
		$retRelFiles = $retOnePeople->files;
		
		//$retCompanies = Company::all();
		//$retDepartments = Department::all();		
		//$department = $retOnePeople->departments->first();
		//$curCompany = $department->company;
		//$retCurCompany = $curCompany->get('id');
		//$retAnotherDepartments = $curCompany->departments;
		//$retCurCompany = null;
		//$retAnotherDepartments = null;		
		//$retFilesData = $retOnePeople->files;
		
		$retData = response()->json(['onepeople' => $retOnePeople, 'relcompanies' => $retRelCompanies, 'reldepartments' => $retRelDepartments, 
			'relfiles' => $retRelFiles]);
		
		return $retData;
	}	
	
	public function update(PeopleRequestUpdate $request, $id)
	{
		$people = People::findOrFail($id);
		$people->fill($request->except(['companies', 'departments', 'files']));
		$people->save();
		
		$people->companies()->sync($this->StrToArrNum($request->companies));
		$people->departments()->sync($this->StrToArrNum($request->departments));
		
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
				$file->move('peoplephoto', $fullname);
				
				//$arrfiles[] = $file;
				//$img = Image::make('others/'.$fullname);
				//$img->resize(40, null, function ($constraint) {$constraint->aspectRatio();});
				//$img->save('thumbnails/'.$fullname);
				
				$recfile = new Storefile;
				$recfile->nameFile = $orignamefile;
				$recfile->pathFile = 'peoplephoto/'.$fullname;
				$recfile->sizeFile = $sizefile;
				$recfile->owner()->associate($people);
				$recfile->save();
			}
		
		return null;
	}
	
	public function store(PeopleRequest $request)
	{
		$people = new People;
		$people->fill($request->except(['companies', 'departments']));
		$people->save();
		$people->companies()->sync($this->StrToArrNum($request->companies));
		$people->departments()->sync($this->StrToArrNum($request->departments));
		
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
				$file->move('peoplephoto', $fullname);
				
				//$arrfiles[] = $file;
				//$img = Image::make('others/'.$fullname);
				//$img->resize(40, null, function ($constraint) {$constraint->aspectRatio();});
				//$img->save('thumbnails/'.$fullname);
				
				$recfile = new Storefile;
				$recfile->nameFile = $orignamefile;
				$recfile->pathFile = 'peoplephoto/'.$fullname;
				$recfile->sizeFile = $sizefile;
				$recfile->owner()->associate($people);
				$recfile->save();
			}
			
		return $request;
	}
	
	public function destroy($id)
	{
		$people = People::findOrFail($id);
		$people->delete();
		return null;
	}	
}
