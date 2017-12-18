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

  }

}
//
//   public function importExcel(Request $request, Exceldata $exceldata){
//
//     if($request->hasFile('import_file')){
//
//     // Get File path
//     $path = Input::file('import_file')->getRealPath();
//
//     $nextId = $exceldata->getUploadId();
//
//     // Load Excel file & reader
//     $data = Excel::load($path, function($reader) use (&$excel) {
//
//        $objExcel = $reader->getExcel();
//        $sheet = $objExcel->getSheet(0);
//        $highestRow = $sheet->getHighestRow();
//        $highestColumn = $sheet->getHighestColumn();
//
//        //  Loop through each row of the worksheet
//        for ($row = 10; $row <= $highestRow; $row++)
//        {
//
//         //  Read a row of data into an array
//         $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
//
//         // сheck if row contains data
//           if(!empty($rowData[0][2])){
//
//           $excel[] = $rowData[0];
//
//           foreach ($excel as $key) {
//
//             $obj = new Exceldata();
//
//               $obj->fill(array(
//                 'uploadId' => $nextId,
//                 'weld' => $key[1],
//                 'diameter' => $key[2],
//                 'thicknes' => $key[3],
//                 'surname' => $key[4],
//                 'steelgrade' => $key[6],
//                 'material' => $key[7],
//                 'weldingdate' => $key[10],
//                 'welderid' => $key[12],
//                 'requestid' => $requestId,
//                 'documentdate' => $date));
//             }
//
//           $obj->save();
//
//         }
//        }
//     });
//
//     return view('fileupload');
//    }
//  }
// }
