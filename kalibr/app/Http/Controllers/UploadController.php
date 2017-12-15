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

	public function import()
	{
		return view('fileupload');
	}

  public function importExcel(){

    $path = Input::file('import_file')->getRealPath();

    $data = Excel::load($path, function($reader) use (&$excel) {

       $objExcel = $reader->getExcel();
       $sheet = $objExcel->getSheet(0);
       $highestRow = $sheet->getHighestRow();
       $highestColumn = $sheet->getHighestColumn();

       // Get Document ID from the cell
       $documentId = $sheet->getCell('C7')->getValue();

       // Get the document date from the cell
       $date = $sheet->getCell('S5')->getValue();

       // Request ID
       $requestId = $sheet->getCell('P4')->getValue();

       $nextId = DB::table('exceldatas')->max('uploadId');

       $nextId++;

       //  Loop through each row of the worksheet
       for ($row = 10; $row <= $highestRow; $row++)
       {

        //  Read a row of data into an array
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

        // сheck if row contains data
          if(!empty($rowData[0][2])){

          $excel[] = $rowData[0];

          foreach ($excel as $key) {

            $obj = new Exceldata();

              $obj->fill(array(
                'uploadId' => $nextId,
                'weld' => $key[1],
                'diameter' => $key[2],
                'thicknes' => $key[3],
                'surname' => $key[4],
                'steelgrade' => $key[6],
                'material' => $key[7],
                'weldingdate' => $key[10],
                'welderid' => $key[12],
                'requestid' => $requestId,
                'documentdate' => $date));
            }

          $obj->save();

        }
       }
    });

    return view('home');
  }
}
