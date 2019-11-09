<?php

namespace App\Http\Controllers\Api\V1;

use App\Company;
use App\Department;
use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentsController extends Controller
{
    //
	public function index()
	{
		$retCompanies = Company::all();
		$retDepartments = Department::all();
		//$retUser = User::all();
		
		$retData = response()->json(['companies' => $retCompanies, 'departments' => $retDepartments]);
		
		//$retData = Company::all();
	   return $retData;
	}
	
	public function create()
	{
		$retCompanies = Company::all();
		//$retDepartments = Department::all();
		//$retUser = User::all();
		
		$retData = response()->json(['companies' => $retCompanies]);
		
		//$retData = Company::all();
	   return $retData;
	}	
	
	
	public function show($id)
	{
		$retCompanies = Company::all();
		$retDepartment = Department::findOrFail($id);
		$retData = response()->json(['companies' => $retCompanies, 'department' => $retDepartment]);
	   return $retData;
	}
	
	public function update(Request $request, $id)
	{
	   $department = Department::findOrFail($id);
	   $department->update($request->all());
	
	   return $department;
	}
	
	public function store(Request $request)
	{
	   $department = Department::create($request->all());
	   return $department;
	}
	
	public function destroy($id)
	{
	   $department = Department::findOrFail($id);
	   $department->delete();
	   return '';
	}
}
