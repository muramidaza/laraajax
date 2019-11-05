<?php

namespace App\Http\Controllers\Api\V1;
	
use App\Company;
use App\Department;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CompaniesController extends Controller
{
	public function index()
	{
		
		$retCompanies = Company::all();
		$retDepartments = Department::all();
		//$retUser = User::all();
		
		$retData = response()->json(['companies' => $retCompanies, 'departments' => $retDepartments]);
		
		//$retData = Company::all();
	   return $retData;
	}
	
	public function show($id)
	{
	   return Company::findOrFail($id);
	}
	
	public function update(Request $request, $id)
	{
	   $company = Company::findOrFail($id);
	   $company->update($request->all());
	
	   return $company;
	}
	
	public function store(Request $request)
	{
	   $company = Company::create($request->all());
	   return $company;
	}
	
	public function destroy($id)
	{
	   $company = Company::findOrFail($id);
	   $company->delete();
	   return '';
	}
}