<?php

namespace App;

use Illuminate\Support\Facades\input;
use Illuminate\Database\Eloquent\Model;

use App\exceldatas;
Use DB;

use Maatwebsite\Excel\Facades\Excel;

class Exceldata extends Model
{
   protected $fillable = [
     'uploadId',
     'weld',
     'diameter',
     'thicknes',
     'surname',
     'steelgrade',
     'material',
     'weldingdate',
     'welderid',
     'requestid',
     'documentdate'
   ];

   // Assign upload ID
   public static function setUploadId()
   {

     $nextId = DB::table('exceldatas')->max('uploadId');

       if($nextId == null)
       {
         $nextId = 0;
       }

     $nextId++;

     return $nextId;

   }

   // Store data into database
   public static function storeData($sheet)
   {

     $highestRow = $sheet->getHighestRow();

     $highestColumn = $sheet->getHighestColumn();

     $nextId = Exceldata::setUploadId();

     $documentId = $sheet->getCell('C7')->getValue();

     $date = $sheet->getCell('S5')->getValue();

     $requestId = $sheet->getCell('O5')->getValue();


     for ($row = 10; $row <= $highestRow; $row++)
     {

        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

        if(!empty($rowData[0][2]))
        {

          $excel[] = $rowData[0];

          foreach ($excel as $key)
          {

            $object = new Exceldata();

              $object->fill(array(

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

          $object->save();

        }

     }

   }


   // Get Upload Id
   public static function getUploadId()
   {

     $uploadId = DB::table('exceldatas')->max('uploadId');

     return $uploadId;

   }


   // Get data
   public static function getData($data)
   {

     // $uploadId = $this->getUploadId();

     // $exceldata = Exceldata::where([
     //   'diameter' => '21.3',
     //   'thicknes' => '2.5',
     //   'steelgrade' => 'Ст20',
     //   'uploadId' => $uploadId
     //
     //   ])->

      // $data->chunk(5, function($rows) {

      $data = $data->chunk(5);

      foreach ($data as $key)   {

        $path = storage_path('/app/excel/331-3-17 72AN - 21.3 - Ст. 20.xlsx');

          Excel::load($path, function($reader) use (&$key)
          {

            $objExcel = $reader->getExcel();

            $sheet = $objExcel->getSheet(0);

            $startingRow = 25;

              foreach ($key as $item => $value)
              {

                if($startingRow < 30)
                {

                  $sheet->getCell('C' . $startingRow)->setValue($value->weld);

                  $startingRow++;

                }

              }

           })

           ->setFilename("331-3-17 72AN - 21.3 - Ст. 20 " . date("d.m.y") . uniqid('21.3 - 2.5 - Ст20 _'))
           ->store('xlsx', storage_path('/app/exports/21.3 - 2.5 - Ст20 '.date('m-d-Y')));

      }


   }
   // werkt ook
   // public function getData()
   // {
   //
   //   $latestUpload = Exceldata::getUploadId();
   //
   //   $users = User::where('votes', '>', 100)->take(10)->get();
   //
   //   $excelData = DB::table('exceldatas')
   //   ->select(array('weld', 'diameter', 'thicknes', 'surname', 'steelgrade', 'material', 'weldingdate', 'welderid', 'requestid', 'documentdate'))
   //   ->where('diameter', '21.3')
   //   ->where('thicknes', '2.5')
   //   ->where('steelgrade', 'Ст20')
   //   ->where('uploadId', $latestUpload)
   //   ->orderBy('created_at', 'DESC')
   //   ->get();
   //
   //   $chunks = $excelData->chunk(5);
   //
   //   $chunks = $chunks->toArray();
   //
   //      foreach ($chunks as $key)   {
   //
   //        // Get the Excel template path
   //        $path = storage_path('/app/excel/331-3-17 72AN - 21.3 - Ст. 20.xlsx');
   //
   //        // Load the excel template file
   //        Excel::load($path, function($reader) use (&$key) {
   //
   //        // Load the Excel sheet
   //        $objExcel = $reader->getExcel();
   //        $sheet = $objExcel->getSheet(0);
   //
   //        // Starting row for sampels
   //        $startingRow = 25;
   //
   //        foreach ($key as $weldId) {
   //
   //            if($startingRow < 30){
   //              $sheet->getCell('C' . $startingRow)->setValue($weldId->weld);
   //              $startingRow++;
   //            }
   //
   //        }
   //
   //      })
   //
   //      ->setFilename("331-3-17 72AN - 21.3 - Ст. 20 " . date("d.m.y") . uniqid('21.3 - 2.5 - Ст20 _'))
   //      ->store('xlsx', storage_path('/app/exports/21.3 - 2.5 - Ст20 '.date('m-d-Y')));
   //    }
   //
   // }
}
