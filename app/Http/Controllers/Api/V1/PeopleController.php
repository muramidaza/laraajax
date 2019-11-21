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
		$retCompanies = Company::all();
		$retDepartments = Department::all();
		$retPeople = People::all();
		
		$retData = response()->json(['people' => $retPeople]);
		
		$retData = Company::all();
		return $retData;
		//return '';
	}
	
	public function create()
	{
		$retCompanies = Company::all();
		$retDepartments = Department::all();
		$retPeople = People::all();
		$retData = response()->json(['companies' => $retCompanies, 'people' => $retPeople, 'depertments' => $retDepartments]);
		return $retData;
	}
	
	public function show($id)
	{
		$retCompanies = Company::all();
		$retDepartments = Department::all();
		$retPeople = People::all();
		$retRelCompanies = People->Companies();
		$retRelDepartment = People->Departments();		
		$retData = response()->json(['companies' => $retCompanies, 'people' => $retPeople, 'depertments' => $retDepartments]);
		return $retData;
	}
}
