<?php

namespace App\Http\Controllers;
use File;
use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\input;
use Maatwebsite\Excel\Facades\Excel;

use App\Exceldata;


class UploadController extends Controller
{

	public function index()
	{

		return view('fileupload');

	}

  public function getImportFile(Request $request)
  {

    if($request->hasFile('import_file'))
    {

      $path = Input::file('import_file')->getRealPath();

      return $data = Excel::load($path, function($reader) use (&$excel)
      {

        $objExcel = $reader->getExcel();

        $sheet = $objExcel->getSheet(0);

        $data = Exceldata::storeData($sheet);

      });

    }

  }

  public function main(Request $request, Exceldata $exceldata)
  {

    $this->getImportFile($request);

    return view('fileupload');

  }

}
