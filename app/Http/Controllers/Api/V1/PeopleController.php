<?php

namespace App\Http\Controllers;

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
		
		//$retData = Company::all();
	   return $retData;
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
		
		$retData = response()->json(['companies' => $retCompanies, 'people' => $retPeople, 'depertments' => $retDepartments]);
	}
	
	public function update(Request $request, $id)
	{
	   $people = People::findOrFail($id);
	   $people->update($request->all());
	
	   return $people;
	}
	
	public function store(Request $request)
	{
	   $people = People::create($request->all());
	   return $people;
	}
	
	public function destroy($id)
	{
	   $people = People::findOrFail($id);
	   $people->delete();
	   $retPeople = People::all();
	   return $retPeople;
	}
}
