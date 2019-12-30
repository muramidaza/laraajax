<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;
use App\Department;
use App\People;
use App\Storefile;

class PeopleController extends Controller
{
	public function index()
	{
		$retPeople = People::all();
		$retData = response()->json(['people' => $retPeople]);
		return $retData;
		//return '';
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
		$retData = response()->json(['companies' => $retCompanies, 'departments' => $retDepartments, 'onepeople' => $retOnePeople, 'relcompanies' => $retRelCompanies, 'reldepartments' => $retRelDepartments]);
		return $retData;
	}
	
	public function update(Request $request, $id)
	{
		$people = People::findOrFail($id);
		$people->fill($request->except(['companies', 'departments']));
		$people->save();
		$people->companies()->sync($request->companies);
		$people->departments()->sync($request->departments);
	
		return '';
	}
	
	public function store(Request $request)
	{

		$people = new People;
		$people->fill($request->except(['companies', 'departments']));
		$people->save();
		$people->companies()->sync($request->companies);
		$people->departments()->sync($request->departments);
		
		$arrfiles = $request['Attachment'];
		

		foreach($arrfiles as $file) {

				$fullname = time().'_'.$file->getClientOriginalName();
				$file->move('peoplephoto', $fullname);
				
				//$arrfiles[] = $file;
				//$img = Image::make('others/'.$fullname);
				//$img->resize(40, null, function ($constraint) {$constraint->aspectRatio();});
				//$img->save('thumbnails/'.$fullname);
				
				$file = new Storefile;
				$file->nameFile = $fullname;
				$file->pathFile = 'peoplephoto/'.$fullname;
				$file->save();
			}
		
		
		return time().'_'.$arrfiles[0];
	}
	
	public function destroy($id)
	{
		$people = People::findOrFail($id);
		$people->delete();
		return '';
	}	
}
