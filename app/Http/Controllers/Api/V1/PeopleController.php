<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;
use App\Department;
use App\People;

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
		$retCompanies = Company::all();
		$retDepartments = Department::all();
		$retPeople = People::all();
		$retRelCompanies = $retPeople->Companies;
		$retRelDepartment = $retPeople->Departments;		
		$retData = response()->json(['companies' => $retCompanies, 'people' => $retPeople, 'depertments' => $retDepartments]);
		return $retData;
	}
	
	public function update(Request $request, $id)
	{
		$people = People::findOrFail($id);
		$people->update($request->all());
		$people->companies()->sync($request->get('setcompanies'));
		$people->departments()->sync($request->get('setdepartments'));
	
		return '';
	}
	
	public function store(Request $request)
	{
		$people = People::create($request->all());
		//$people->companies()->sync($request->get('setcompanies'));
		//$people->departments()->sync($request->get('setdepartments'));		
		return '';
	}
	
	public function destroy($id)
	{
		$people = People::findOrFail($id);
		$people->delete();
		return '';
	}	
}
