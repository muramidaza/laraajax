<?php
namespace App\Http\Controllers\api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Company;
use App\Department;
use App\Person;
use App\Storefile;

class SearchController extends Controller
{
    //
	public function searchdepartments($id) {
		if($id >= 0) {
			$findCompany = Company::findOrFail($id);
			$retDepartments = $findCompany->departments;
			$retData = response()->json(['departments' => $retDepartments]);
			return $retData;
		}
		return null;
	}
	
	public function searchcompanies() {
		$retCompanies = Company::all();
		$retData = response()->json(['companies' => $retCompanies]);
		return $retData;
	}
	
	public function searchpersons() {
		$retPersons = Person::all();
		$retData = response()->json(['persons' => $retPersons]);
		return $retData;
	}		
}
