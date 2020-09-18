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
	
	public function indexpage($idcompany) //отличается от searchdepartments тем что возвращает еще и компанию
	{
		if($idcompany == -1) {
			$retDepartments = Department::all();
			$retData = response()->json(['departments' => $retDepartments]);
			return $retData;
		} else {			
			$retCompany = Company::findOrFail($idcompany);
			$retDepartments = Department::where('company_id', $idcompany)->get();
			forEach($retDepartments as $department) {
				$department->equipments;
				$department->persons;
				$department->acts;
			};
		};
		$retData = response()->json(['departments' => $retDepartments, 'company' => $retCompany]);
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
		$retDepartment->equipments;
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
	
	public function extendsearchdepartments($id) {
		if($id >= 0) {
			$findDepartment = Department::findOrFail($id); //находим запись об отделе по его ID
			$retCompany = $findDepartment->company; //находим компанию к которой принадлежит отдел
			$retDepartments = $retCompany->departments; //находим все отделы принадлежащие компании, к которой принадлежин заданный отдел, т. е. все отделы компании, в которой есть этот отдел
			$retData = response()->json(['departments' => $retDepartments, 'company' => $retCompany]);
			return $retData;
		}
		return null;
	}

	public function searchdepartments($id) {
		if($id >= 0) {
			$findCompany = Company::findOrFail($id);
			$retDepartments = $findCompany->departments;
			$retData = response()->json(['departments' => $retDepartments]);
			return $retData;
		}
		return null;
	}	
}
