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

   public static function getUploadId()
   {

     $nextId = DB::table('exceldatas')->max('uploadId');

     if($nextId == null)
     {
       $nextId = 0;
     }

     $nextId++;

     return $nextId;

   }

   public static function storeData($sheet)
   {

     $highestRow = $sheet->getHighestRow();

     $highestColumn = $sheet->getHighestColumn();

     $nextId = Exceldata::getUploadId();

     $documentId = $sheet->getCell('C7')->getValue();

     $date = $sheet->getCell('S5')->getValue();

     $requestId = $sheet->getCell('P4')->getValue();


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

   pubic function getData()
   {
     
   }

}
