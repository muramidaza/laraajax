<?php

namespace App\Http\Controllers\Api\V1;
	
use App\Company;
use App\Department;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyRequestUpdate;


class CompaniesController extends Controller
{
	public function index()
	{
		
		$retCompanies = Company::all();
		//$retDepartments = Department::all();
		//$retUser = User::all();
		
		$retData = response()->json(['companies' => $retCompanies]);
		return $retData;
	}
	
	public function show($id)
	{
		return Company::findOrFail($id);
	}
	
	public function edit($id)
	{
		return Company::findOrFail($id);
	}	
	
	public function update(CompanyRequestUpdate $request, $id)
	{
		$company = Company::findOrFail($id);
		$company->update($request->all());
		return null;
	}
	
	public function store(CompanyRequest $request)
	{
		$company = Company::create($request->all());
		return null;
	}
	
	public function destroy($id)
	{
		$company = Company::findOrFail($id);
		$company->delete();
		return null;
	}
}