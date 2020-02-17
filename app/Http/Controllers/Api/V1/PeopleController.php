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

	}

	public function edit($id)
	{
		function dataToArr($data) {
			$arr = [];
			foreach($data->toArray() as $elem) {
				$arr[] = $elem['id'];
			}
			return $arr;
		}

		$retCompanies = Company::all();
		$retDepartments = Department::all();
		
		$retOnePeople = People::findOrFail($id);
		
		$retRelCompanies = dataToArr($retOnePeople->companies);
		$retRelDepartments = dataToArr($retOnePeople->departments);
		$retFilesData = $retOnePeople->files;
		$retRelFiles = dataToArr($retOnePeople->files);
		$retData = response()->json(['companies' => $retCompanies, 'departments' => $retDepartments, 'onepeople' => $retOnePeople, 'relcompanies' => $retRelCompanies, 'reldepartments' => $retRelDepartments, 
			'relfiles' => $retRelFiles, 'filesdata' => $retFilesData]);
		
		return $retData;
	}	
	
	public function update(Request $request, $id)
	{
		$people = People::findOrFail($id);
		$people->fill($request->except(['companies', 'departments', 'files']));
		$people->save();
		$people->companies()->sync($request->companies);
		$people->departments()->sync($request->departments);
		//$people->files()->sync($request->files);
		
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
		if(!$arrfiles) return $arrDeleteFiles;
		
		foreach($arrfiles as $file) {

				$fullname = time().'_'.$file->getClientOriginalName();
				$sizefile = $file->getSize();
				$file->move('peoplephoto', $fullname);
				
				//$arrfiles[] = $file;
				//$img = Image::make('others/'.$fullname);
				//$img->resize(40, null, function ($constraint) {$constraint->aspectRatio();});
				//$img->save('thumbnails/'.$fullname);
				
				$recfile = new Storefile;
				$recfile->nameFile = $fullname;
				$recfile->pathFile = 'peoplephoto/'.$fullname;
				$recfile->sizeFile = $sizefile;
				$recfile->owner()->associate($people);
				$recfile->save();
			}
		
		return $arrDeleteFiles;
	}
	
	public function store(PeopleRequest $request)
	{

		$people = new People;
		$people->fill($request->except(['companies', 'departments']));
		$people->save();
		$people->companies()->sync($request->companies);
		$people->departments()->sync($request->departments);
		
		$arrfiles = $request['Attachment'];
		
		if(!$arrfiles) return $request;
		
		foreach($arrfiles as $file) {

				$fullname = time().'_'.$file->getClientOriginalName();
				$sizefile = $file->getSize();
				$file->move('peoplephoto', $fullname);
				
				//$arrfiles[] = $file;
				//$img = Image::make('others/'.$fullname);
				//$img->resize(40, null, function ($constraint) {$constraint->aspectRatio();});
				//$img->save('thumbnails/'.$fullname);
				
				$recfile = new Storefile;
				$recfile->nameFile = $fullname;
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
