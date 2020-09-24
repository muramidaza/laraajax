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
		$retData = response()->json(['companies' => $retCompanies]);
		return $retData;
	}
	
    public function indexpage($count, $id, $onlyContract)
    {
		if($onlyContract) {
			$retCompanies = Company::whereNotNull('contract')->offset($count * ($id - 1))->limit($count)->get(); 
		} else {
			$retCompanies = Company::offset($count * ($id - 1))->limit($count)->get(); 
		};
		forEach($retCompanies as $company) {
			$company->departments;
			$company->persons;
			$company->equipments;
			$company->acts;
		};
		$retCountRecords = Company::count();
		$retData = response()->json(['companies' => $retCompanies, 'countrecords' => $retCountRecords]);
		return $retData;        
    }	
	
	public function show($id)
	{
		$retCompany = Company::findOrFail($id);
		$retCompany->departments;
		$retCompany->persons;
		$retCompany->equipments;
		$retData = response()->json(['company' => $retCompany]);		
		return $retData;
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
	
	public function searchcompanies() {
		$retCompanies = Company::all();
		$retData = response()->json(['companies' => $retCompanies]);
		return $retData;
	}	
}