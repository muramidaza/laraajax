<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;
use App\Department;
use App\User;
use App\Storefile;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserRequestUpdate;

class UsersController extends Controller
{
	private function StrToArrNum($str) {
		if(strlen($str) == 0) return [];
		$arr = explode(',', $str);
		$arrreturn = [];
		foreach($arr as $elem) {
			$arrreturn[] = +$elem;
		}
		return $arrreturn;
	}
	
	public function index()
	{
		$retUsers = User::all();
		$retData = response()->json(['users' => $retUsers]);
		return $retData;
	}
	
	public function create()
	{
		return null;
	}
	
	public function show($id)
	{
		$retUser = User::findOrFail($id);
		$retUser->files;
		$retData = response()->json(['user' => $retUser]);
		
		return $retData;
	}

	public function edit($id)
	{
		$retUser = User::findOrFail($id);
		$retUser->files;		
		$retData = response()->json(['user' => $retUser]);
		return $retData;
	}	
	
	public function update(Request $request, $id)
	{
		$user = User::findOrFail($id);
		$user->fill($request->except(['files']));
		$user->save();
		
		$strDeleteFiles = $request['delfiles'];
		
 		if($strDeleteFiles) {
			$arrDeleteFiles = explode(',', $strDeleteFiles);
			
			foreach($arrDeleteFiles as $delFileID) {
				$delfile = Storefile::findOrFail($delFileID);
				unlink($delfile->pathFile);
				$delfile->delete();
			}		
		}
		
		$arrfiles = $request['Attachment'];
		if(!$arrfiles) return null;
		
		foreach($arrfiles as $key => $file) {
				$orignamefile = $file->getClientOriginalName();
				$datestr = date('d_m_Y');
				$personname = $request['name'];
				if($request['surname']) $personname = $personname.'_'.$request['surname'];
				if($request['patronymic']) $personname = $personname.'_'.$request['patronymic'];
				$fileextension =  substr($orignamefile, strrpos($orignamefile, '.') + 1);
				$fullname = $key.'_'.$datestr.'_'.$personname.'.'.$fileextension;
				
				$sizefile = $file->getSize();
				$file->move('personsphoto', $fullname);
				
				//$arrfiles[] = $file;
				//$img = Image::make('others/'.$fullname);
				//$img->resize(40, null, function ($constraint) {$constraint->aspectRatio();});
				//$img->save('thumbnails/'.$fullname);
				
				$recfile = new Storefile;
				$recfile->nameFile = $orignamefile;
				$recfile->pathFile = 'personsphoto/'.$fullname;
				$recfile->sizeFile = $sizefile;
				$recfile->typeFile = $fileextension;
				$recfile->owner()->associate($user);
				$recfile->save();
			}
		
		return null;
	}
	
	public function store(Request $request)
	{
		return null;
	}
	
	public function destroy($id)
	{
		$user = User::findOrFail($id);
		$user->delete();
		return null;
	}	
}
