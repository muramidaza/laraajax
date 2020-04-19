<?php

namespace App\Http\Controllers\Api\V1;

use App\Company;
use App\Department;
use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Http\Requests\DepartmentRequestUpdate;

class DepartmentsController extends Controller
{
	public function index()
	{
		$retDepartments = Department::all();
		$retData = response()->json(['departments' => $retDepartments]);
		return $retData;
	}
	
	public function create()
	{
		$retCompanies = Company::all();
		$retData = response()->json(['companies' => $retCompanies]);
		return $retData;
	}	
	
	public function show($id)
	{
		$retDepartment = Department::findOrFail($id);
		$retDepartment->company;
		$retDepartment->persons;
		$retDepartment->equipment;
		$retData = response()->json(['department' => $retDepartment]);
		return $retData;
	}
	
	public function edit($id)
	{
		$retCompanies = Company::all();
		$retDepartment = Department::findOrFail($id);
		$retDepartment->company;
		$retData = response()->json(['companies' => $retCompanies, 'department' => $retDepartment]);
		return $retData;
	}	
	
	public function update(DepartmentRequestUpdate $request, $id)
	{
		$department = Department::findOrFail($id);
		$department->update($request->all());
		return null;
	}
	
	public function store(DepartmentRequest $request)
	{
		$department = Department::create($request->all());
		return null;
	}
	
	public function destroy($id)
	{
		$department = Department::findOrFail($id);
		$department->delete();
		return null;
	}
}
