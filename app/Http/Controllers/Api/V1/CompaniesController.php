<?php

namespace App\Http\Controllers\Api\V1;
	
use App\Company;
use App\Department;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompaniesRequest;


class CompaniesController extends Controller
{
	public function index()
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
		return Company::findOrFail($id);
	}
	
	public function update(Request $request, $id)
	{
		$company = Company::findOrFail($id);
		$company->update($request->all());
		return $company;
	}
	
	public function store(CompaniesRequest $request)
	{
		$company = Company::create($request->all());
		return '';
	}
	
	public function destroy($id)
	{
		$company = Company::findOrFail($id);
		$company->delete();
		return '';
	}
}