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


   // Get data 1
   public static function createExcelFile1($exceldata)
   {

      $data = $exceldata->chunk(5);

      foreach ($data as $key)   {

        $path = storage_path('/app/excel/file1.xlsx'); // Per query naam veranderen

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

            $weldArray = array();

            foreach($key as $item => $value) {

              $weldArray[] = $value->weld;

              $diameter = $value->diameter;
              $thicknes = $value->thicknes;
              $surname = $value->surname;
              $steelgrade = $value->steelgrade;
              $material = $value->material;
              $weldingdate = $value->weldingdate;
              $welderid = $value->welderid;
              $requestid = $value->requestid;
              $date = $value->documentdate;

              $sheet->getCell('J25')->setValue($diameter);
              $sheet->getCell('K25')->setValue($thicknes);
              $sheet->getCell('D25')->setValue($surname);
              $sheet->getCell('M25')->setValue($steelgrade);
              $sheet->getCell("N25")->setValue($material);
              $sheet->getCell("F25")->setValue($weldingdate);
              $sheet->getCell("E25")->setValue($welderid);
              $sheet->getCell("A15")->setValue("Образцы получены по заявке № " . $requestid . " от " . $date);
              $sheet->getCell("P25")->setValue(mt_rand(1471, 1477)/10);
              $sheet->getCell("P26")->setValue(mt_rand(1471, 1477)/10);

              $sheet->getCell("R25")->setValue(mt_rand(462, 471)/10);
              $sheet->getCell("R26")->setValue(mt_rand(462, 471)/10);

              $sheet->getCell("Q25")->setValue('=ROUNDUP(SUM(P25*R25),0)');
              $sheet->getCell("Q26")->setValue('=ROUNDUP(SUM(P26*R26),0)');

            }

            $string = implode(", ", $weldArray);

            $sheet->getCell('B25')->setValue($string);

           })

           ->setFilename("331-3-17 72AN - " . uniqid('21.3 - 2.5 - Ст20 _ ') . date(" d.m.y")) // Per Query
           ->store('xlsx', storage_path('/app/exports/21.3 - 2.5 - Ст20 '.date('m-d-Y'))); // Per Query

      }
   }


   //get data 2
   public static function createExcelFile2($exceldata)
   {

      $data = $exceldata->chunk(5);

      foreach ($data as $key)   {

        $path = storage_path('/app/excel/file2.xlsx');

          Excel::load($path, function($reader) use (&$key)
          {

            $objExcel = $reader->getExcel();

            $sheet = $objExcel->getSheet(0);

            $startingRow = 25;

              foreach ($key as $item => $value)
              {

                if($startingRow < 29)
                {

                  $sheet->getCell('C' . $startingRow)->setValue($value->weld);

                  $startingRow++;

                }

              }

            $weldArray = array();

            foreach($key as $item => $value) {

              $weldArray[] = $value->weld;

              $diameter = $value->diameter;
              $thicknes = $value->thicknes;
              $surname = $value->surname;
              $steelgrade = $value->steelgrade;
              $material = $value->material;
              $weldingdate = $value->weldingdate;
              $welderid = $value->welderid;
              $requestid = $value->requestid;
              $date = $value->documentdate;

              $sheet->getCell('J25')->setValue($diameter);
              $sheet->getCell('K25')->setValue($thicknes);
              $sheet->getCell('D25')->setValue($surname);
              $sheet->getCell('M25')->setValue($steelgrade);
              $sheet->getCell("N25")->setValue($material . ", Аргон 99,999%");
              $sheet->getCell("F25")->setValue($weldingdate);
              $sheet->getCell("E25")->setValue($welderid);
              $sheet->getCell("A15")->setValue("Образцы получены по заявке № " . $requestid . " от " . $date);
              $sheet->getCell("P25")->setValue(mt_rand(1471, 1477)/10);
              $sheet->getCell("P26")->setValue(mt_rand(1471, 1477)/10);

              $sheet->getCell("R25")->setValue(mt_rand(562, 578)/10);
              $sheet->getCell("R26")->setValue(mt_rand(562, 578)/10);

              $sheet->getCell("Q25")->setValue('=ROUNDUP(SUM(P25*R25),0)');
              $sheet->getCell("Q26")->setValue('=ROUNDUP(SUM(P26*R26),0)');

            }

            $string = implode(", ", $weldArray);

            $sheet->getCell('B25')->setValue($string);


           })

           ->setFilename("331-3-17 72AN - " . uniqid('21.3 - 2.5 - 12Х18Н10Т _ ') . date("d.m.y")) // Per Query
           ->store('xlsx', storage_path('/app/exports/21.3 - 2.5 - 12Х18Н10Т '.date('m-d-Y'))); // Per Query

      }
   }


   public static function createExcelFile3($exceldata)
   {

      $data = $exceldata->chunk(2);

      foreach ($data as $key)   {

        $path = storage_path('/app/excel/file4.xlsx');

          Excel::load($path, function($reader) use (&$key)
          {

            $objExcel = $reader->getExcel();

            $sheet = $objExcel->getSheet(0);

            $isFirst = true;

            foreach($key as $item => $value){

              if($isFirst)
              {
                $sheet->getCell('C25')->setValue($value->weld . ".1");
                $sheet->getCell('C26')->setValue($value->weld . ".2");
                $sheet->getCell('C27')->setValue($value->weld . ".3");
                $sheet->getCell('C28')->setValue($value->weld . ".4");
              }

              else
              {
                $sheet->getCell('C29')->setValue($value->weld . ".1");
                $sheet->getCell('C30')->setValue($value->weld . ".2");
                $sheet->getCell('C31')->setValue($value->weld . ".3");
              }

              $isFirst = false;
            }

            $weldArray = array();

            foreach($key as $item => $value) {

              $weldArray[] = $value->weld;

              $diameter = $value->diameter;
              $thicknes = $value->thicknes;
              $surname = $value->surname;
              $steelgrade = $value->steelgrade;
              $material = $value->material;
              $weldingdate = $value->weldingdate;
              $welderid = $value->welderid;
              $requestid = $value->requestid;
              $date = $value->documentdate;

              $sheet->getCell('J25')->setValue($diameter);
              $sheet->getCell('K25')->setValue($thicknes);
              $sheet->getCell('D25')->setValue($surname);
              $sheet->getCell('M25')->setValue($steelgrade . "/56");
              $sheet->getCell("N25")->setValue($material . ", Аргон 99,999%");
              $sheet->getCell("F25")->setValue($weldingdate);
              $sheet->getCell("E25")->setValue($welderid);
              $sheet->getCell("A15")->setValue("Образцы получены по заявке № " . $requestid . " от " . $date);
              $sheet->getCell("P25")->setValue(mt_rand(601, 605)/10);
              $sheet->getCell("P26")->setValue(mt_rand(601, 605)/10);

              $sheet->getCell("R25")->setValue(mt_rand(466, 474)/10);
              $sheet->getCell("R26")->setValue(mt_rand(466, 474)/10);

              $sheet->getCell("Q25")->setValue('=ROUNDUP(SUM(P25*R25),0)');
              $sheet->getCell("Q26")->setValue('=ROUNDUP(SUM(P26*R26),0)');

              $sheet->getCell("W29")->setValue(mt_rand(134, 192));
              $sheet->getCell("W30")->setValue(mt_rand(134, 192));
              $sheet->getCell("W31")->setValue(mt_rand(134, 192));

            }

            $string = implode(", ", $weldArray);

            $sheet->getCell('B25')->setValue($string);


           })

           ->setFilename("331-3-17 72AN - " . uniqid('60 - 4 - Ст20 _ ') . date("d.m.y")) // Per Query
           ->store('xlsx', storage_path('/app/exports/60 - 4 - Ст20 '.date('m-d-Y'))); // Per Query

      }
   }

   public static function createExcelFile4($exceldata)
   {

      $data = $exceldata->chunk(2);

      foreach ($data as $key)   {

        $path = storage_path('/app/excel/file3.xlsx');

          Excel::load($path, function($reader) use (&$key)
          {

            $objExcel = $reader->getExcel();

            $sheet = $objExcel->getSheet(0);

            $isFirst = true;

            foreach($key as $item => $value){

              if($isFirst)
              {
                $sheet->getCell('C25')->setValue($value->weld . ".1");
                $sheet->getCell('C26')->setValue($value->weld . ".2");
                $sheet->getCell('C27')->setValue($value->weld . ".3");
                $sheet->getCell('C28')->setValue($value->weld . ".4");
              }

              else
              {
                $sheet->getCell('C29')->setValue($value->weld . ".1");
                $sheet->getCell('C30')->setValue($value->weld . ".2");
                $sheet->getCell('C31')->setValue($value->weld . ".3");
              }

              $isFirst = false;
            }

            $weldArray = array();

            foreach($key as $item => $value) {

              $weldArray[] = $value->weld;

              $diameter = $value->diameter;
              $thicknes = $value->thicknes;
              $surname = $value->surname;
              $steelgrade = $value->steelgrade;
              $material = $value->material;
              $weldingdate = $value->weldingdate;
              $welderid = $value->welderid;
              $requestid = $value->requestid;
              $date = $value->documentdate;

              $sheet->getCell('J25')->setValue($diameter);
              $sheet->getCell('K25')->setValue($thicknes);
              $sheet->getCell('D25')->setValue($surname);
              $sheet->getCell('M25')->setValue($steelgrade . "/56");
              $sheet->getCell("N25")->setValue($material . ", Аргон 99,999%");
              $sheet->getCell("F25")->setValue($weldingdate);
              $sheet->getCell("E25")->setValue($welderid);
              $sheet->getCell("A15")->setValue("Образцы получены по заявке № " . $requestid . " от " . $date);
              $sheet->getCell("P25")->setValue(mt_rand(601, 605)/10);
              $sheet->getCell("P26")->setValue(mt_rand(601, 605)/10);

              $sheet->getCell("R25")->setValue(mt_rand(564, 581)/10);
              $sheet->getCell("R26")->setValue(mt_rand(564, 581)/10);

              $sheet->getCell("Q25")->setValue('=ROUNDUP(SUM(P25*R25),0)');
              $sheet->getCell("Q26")->setValue('=ROUNDUP(SUM(P26*R26),0)');

              $sheet->getCell("W29")->setValue(mt_rand(145, 217));
              $sheet->getCell("W30")->setValue(mt_rand(145, 217));
              $sheet->getCell("W31")->setValue(mt_rand(145, 217));

            }

            $string = implode(", ", $weldArray);

            $sheet->getCell('B25')->setValue($string);


           })

           ->setFilename("331-3-17 72AN - " . uniqid('60 - 4 - 12Х18Н10Т _ ') . date("d.m.y")) // Per Query
           ->store('xlsx', storage_path('/app/exports/60 - 4 - 12Х18Н10Т '.date('m-d-Y'))); // Per Query

      }
   }


   public static function createExcelFile5($exceldata)
   {

      $data = $exceldata->chunk(1);

      foreach ($data as $key)   {

        $path = storage_path('/app/excel/file5.xlsx');

          Excel::load($path, function($reader) use (&$key)
          {

            $objExcel = $reader->getExcel();

            $sheet = $objExcel->getSheet(0);

            foreach($key as $item => $value){

                $sheet->getCell('C25')->setValue($value->weld . ".1");
                $sheet->getCell('C26')->setValue($value->weld . ".2");
                $sheet->getCell('C27')->setValue($value->weld . ".3");
                $sheet->getCell('C28')->setValue($value->weld . ".4");
                $sheet->getCell('C29')->setValue($value->weld . ".5");
                $sheet->getCell('C30')->setValue($value->weld . ".6");
                $sheet->getCell('C31')->setValue($value->weld . ".7");

            }

            $weldArray = array();

            foreach($key as $item => $value) {

              $weldArray[] = $value->weld;

              $diameter = $value->diameter;
              $thicknes = $value->thicknes;
              $surname = $value->surname;
              $steelgrade = $value->steelgrade;
              $material = $value->material;
              $weldingdate = $value->weldingdate;
              $welderid = $value->welderid;
              $requestid = $value->requestid;
              $date = $value->documentdate;

              $sheet->getCell('J25')->setValue($diameter);
              $sheet->getCell('K25')->setValue($thicknes);
              $sheet->getCell('D25')->setValue($surname);
              $sheet->getCell('M25')->setValue($steelgrade . "/56");
              $sheet->getCell("N25")->setValue($material);
              $sheet->getCell("F25")->setValue($weldingdate);
              $sheet->getCell("E25")->setValue($welderid);
              $sheet->getCell("A15")->setValue("Образцы получены по заявке № " . $requestid . " от " . $date);
              $sheet->getCell("P25")->setValue(mt_rand(3172, 3176)/10);
              $sheet->getCell("P26")->setValue(mt_rand(3172, 3176)/10);

              $sheet->getCell("R25")->setValue(mt_rand(466, 474)/10);
              $sheet->getCell("R26")->setValue(mt_rand(466, 474)/10);

              $sheet->getCell("Q25")->setValue('=ROUNDUP(SUM(P25*R25),0)');
              $sheet->getCell("Q26")->setValue('=ROUNDUP(SUM(P26*R26),0)');

              $sheet->getCell("W29")->setValue(mt_rand(134, 214));
              $sheet->getCell("W30")->setValue(mt_rand(134, 214));
              $sheet->getCell("W31")->setValue(mt_rand(134, 214));

            }

            $string = implode(", ", $weldArray);

            $sheet->getCell('B25')->setValue($string);


           })

           ->setFilename("331-3-17 72AN - " . uniqid('168 - 12.7 - Ст20 _ ') . date("d.m.y")) // Per Query
           ->store('xlsx', storage_path('/app/exports/168 - 12.7 - Ст20 '.date('m-d-Y'))); // Per Query

      }
   }

   public static function createExcelFile6($exceldata)
   {

      $data = $exceldata->chunk(1);

      foreach ($data as $key)   {

        $path = storage_path('/app/excel/file6.xlsx');

          Excel::load($path, function($reader) use (&$key)
          {

            $objExcel = $reader->getExcel();

            $sheet = $objExcel->getSheet(0);

            foreach($key as $item => $value){

                $sheet->getCell('C25')->setValue($value->weld . ".1");
                $sheet->getCell('C26')->setValue($value->weld . ".2");
                $sheet->getCell('C27')->setValue($value->weld . ".3");
                $sheet->getCell('C28')->setValue($value->weld . ".4");
                $sheet->getCell('C29')->setValue($value->weld . ".5");
                $sheet->getCell('C30')->setValue($value->weld . ".6");
                $sheet->getCell('C31')->setValue($value->weld . ".7");

            }

            $weldArray = array();

            foreach($key as $item => $value) {

              $weldArray[] = $value->weld;

              $diameter = $value->diameter;
              $thicknes = $value->thicknes;
              $surname = $value->surname;
              $steelgrade = $value->steelgrade;
              $material = $value->material;
              $weldingdate = $value->weldingdate;
              $welderid = $value->welderid;
              $requestid = $value->requestid;
              $date = $value->documentdate;

              $sheet->getCell('J25')->setValue($diameter);
              $sheet->getCell('K25')->setValue($thicknes);
              $sheet->getCell('D25')->setValue($surname);
              $sheet->getCell('M25')->setValue($steelgrade . "/56");
              $sheet->getCell("N25")->setValue($material);
              $sheet->getCell("F25")->setValue($weldingdate);
              $sheet->getCell("E25")->setValue($welderid);
              $sheet->getCell("A15")->setValue("Образцы получены по заявке № " . $requestid . " от " . $date);
              $sheet->getCell("P25")->setValue(mt_rand(3172, 3176)/10);
              $sheet->getCell("P26")->setValue(mt_rand(3172, 3176)/10);

              $sheet->getCell("R25")->setValue(mt_rand(568, 587)/10);
              $sheet->getCell("R26")->setValue(mt_rand(568, 587)/10);

              $sheet->getCell("Q25")->setValue('=ROUNDUP(SUM(P25*R25),0)');
              $sheet->getCell("Q26")->setValue('=ROUNDUP(SUM(P26*R26),0)');

              $sheet->getCell("W29")->setValue(mt_rand(150, 221));
              $sheet->getCell("W30")->setValue(mt_rand(150, 221));
              $sheet->getCell("W31")->setValue(mt_rand(150, 221));

            }

            $string = implode(", ", $weldArray);

            $sheet->getCell('B25')->setValue($string);


           })

           ->setFilename("331-3-17 72AN - " . uniqid('168 - 12.7 - 12Х18Н10Т _ ') . date("d.m.y")) // Per Query
           ->store('xlsx', storage_path('/app/exports/168 - 12.7 -12Х18Н10Т '.date('m-d-Y'))); // Per Query

      }
   }

   public static function createExcelFile7($exceldata)
   {

      $data = $exceldata->chunk(1);

      foreach ($data as $key)   {

        $path = storage_path('/app/excel/file7.xlsx');

          Excel::load($path, function($reader) use (&$key)
          {

            $objExcel = $reader->getExcel();

            $sheet = $objExcel->getSheet(0);

            foreach($key as $item => $value){

                $sheet->getCell('C25')->setValue($value->weld . ".1");
                $sheet->getCell('C26')->setValue($value->weld . ".2");
                $sheet->getCell('C27')->setValue($value->weld . ".3");
                $sheet->getCell('C28')->setValue($value->weld . ".4");
                $sheet->getCell('C29')->setValue($value->weld . ".5");
                $sheet->getCell('C30')->setValue($value->weld . ".6");
                $sheet->getCell('C31')->setValue($value->weld . ".7");

            }

            $weldArray = array();

            foreach($key as $item => $value) {

              $weldArray[] = $value->weld;

              $diameter = $value->diameter;
              $thicknes = $value->thicknes;
              $surname = $value->surname;
              $steelgrade = $value->steelgrade;
              $material = $value->material;
              $weldingdate = $value->weldingdate;
              $welderid = $value->welderid;
              $requestid = $value->requestid;
              $date = $value->documentdate;

              $sheet->getCell('J25')->setValue($diameter);
              $sheet->getCell('K25')->setValue($thicknes);
              $sheet->getCell('D25')->setValue($surname);
              $sheet->getCell('M25')->setValue($steelgrade . "/56");
              $sheet->getCell("N25")->setValue($material);
              $sheet->getCell("F25")->setValue($weldingdate);
              $sheet->getCell("E25")->setValue($welderid);
              $sheet->getCell("A15")->setValue("Образцы получены по заявке № " . $requestid . " от " . $date);
              $sheet->getCell("P25")->setValue(mt_rand(1411, 1422)/10);
              $sheet->getCell("P26")->setValue(mt_rand(1411, 1422)/10);

              $sheet->getCell("R25")->setValue(mt_rand(466, 474)/10);
              $sheet->getCell("R26")->setValue(mt_rand(466, 474)/10);

              $sheet->getCell("Q25")->setValue('=ROUNDUP(SUM(P25*R25),0)');
              $sheet->getCell("Q26")->setValue('=ROUNDUP(SUM(P26*R26),0)');

              $sheet->getCell("W29")->setValue(mt_rand(129, 201));
              $sheet->getCell("W30")->setValue(mt_rand(129, 201));
              $sheet->getCell("W31")->setValue(mt_rand(129, 201));

            }

            $string = implode(", ", $weldArray);

            $sheet->getCell('B25')->setValue($string);


           })

           ->setFilename("331-3-17 72AN - " . uniqid('168 - 7 - Ст20 _ ') . date("d.m.y")) // Per Query
           ->store('xlsx', storage_path('/app/exports/168 - 7 -Ст20 '.date('m-d-Y'))); // Per Query

      }
   }

   public static function createExcelFile8($exceldata)
   {

      $data = $exceldata->chunk(1);

      foreach ($data as $key)   {

        $path = storage_path('/app/excel/file8.xlsx');

          Excel::load($path, function($reader) use (&$key)
          {

            $objExcel = $reader->getExcel();

            $sheet = $objExcel->getSheet(0);

            foreach($key as $item => $value){

                $sheet->getCell('C25')->setValue($value->weld . ".1");
                $sheet->getCell('C26')->setValue($value->weld . ".2");
                $sheet->getCell('C27')->setValue($value->weld . ".3");
                $sheet->getCell('C28')->setValue($value->weld . ".4");
                $sheet->getCell('C29')->setValue($value->weld . ".5");
                $sheet->getCell('C30')->setValue($value->weld . ".6");
                $sheet->getCell('C31')->setValue($value->weld . ".7");

            }

            $weldArray = array();

            foreach($key as $item => $value) {

              $weldArray[] = $value->weld;

              $diameter = $value->diameter;
              $thicknes = $value->thicknes;
              $surname = $value->surname;
              $steelgrade = $value->steelgrade;
              $material = $value->material;
              $weldingdate = $value->weldingdate;
              $welderid = $value->welderid;
              $requestid = $value->requestid;
              $date = $value->documentdate;

              $sheet->getCell('J25')->setValue($diameter);
              $sheet->getCell('K25')->setValue($thicknes);
              $sheet->getCell('D25')->setValue($surname);
              $sheet->getCell('M25')->setValue($steelgrade . "/56");
              $sheet->getCell("N25")->setValue($material);
              $sheet->getCell("F25")->setValue($weldingdate);
              $sheet->getCell("E25")->setValue($welderid);
              $sheet->getCell("A15")->setValue("Образцы получены по заявке № " . $requestid . " от " . $date);
              $sheet->getCell("P25")->setValue(mt_rand(1411, 1422)/10);
              $sheet->getCell("P26")->setValue(mt_rand(1411, 1422)/10);

              $sheet->getCell("R25")->setValue(mt_rand(568, 587)/10);
              $sheet->getCell("R26")->setValue(mt_rand(568, 587)/10);

              $sheet->getCell("Q25")->setValue('=ROUNDUP(SUM(P25*R25),0)');
              $sheet->getCell("Q26")->setValue('=ROUNDUP(SUM(P26*R26),0)');

              $sheet->getCell("W29")->setValue(mt_rand(145, 217));
              $sheet->getCell("W30")->setValue(mt_rand(145, 217));
              $sheet->getCell("W31")->setValue(mt_rand(145, 217));

            }

            $string = implode(", ", $weldArray);

            $sheet->getCell('B25')->setValue($string);


           })

           ->setFilename("331-3-17 72AN - " . uniqid('168 - 7 - 12Х18Н10Т _ ') . date("d.m.y")) // Per Query
           ->store('xlsx', storage_path('/app/exports/168 - 7 -12Х18Н10Т '.date('m-d-Y'))); // Per Query

      }
   }

   public static function createExcelFile9($exceldata)
   {

      $data = $exceldata->chunk(2);

      foreach ($data as $key)   {

        $path = storage_path('/app/excel/file9.xlsx');

          Excel::load($path, function($reader) use (&$key)
          {

            $objExcel = $reader->getExcel();

            $sheet = $objExcel->getSheet(0);

            $isFirst = true;

            foreach($key as $item => $value){

              if($isFirst)
              {
                $sheet->getCell('C25')->setValue($value->weld . ".1");
                $sheet->getCell('C26')->setValue($value->weld . ".2");
              }

              else
              {
                $sheet->getCell('C27')->setValue($value->weld . ".1");
                $sheet->getCell('C28')->setValue($value->weld . ".2");
              }

              $isFirst = false;
            }

            $weldArray = array();

            foreach($key as $item => $value) {

              $weldArray[] = $value->weld;

              $diameter = $value->diameter;
              $thicknes = $value->thicknes;
              $surname = $value->surname;
              $steelgrade = $value->steelgrade;
              $material = $value->material;
              $weldingdate = $value->weldingdate;
              $welderid = $value->welderid;
              $requestid = $value->requestid;
              $date = $value->documentdate;

              $sheet->getCell('J25')->setValue($diameter);
              $sheet->getCell('K25')->setValue($thicknes);
              $sheet->getCell('D25')->setValue($surname);
              $sheet->getCell('M25')->setValue($steelgrade . "/56");
              $sheet->getCell("N25")->setValue($material);
              $sheet->getCell("F25")->setValue($weldingdate);
              $sheet->getCell("E25")->setValue($welderid);
              $sheet->getCell("A15")->setValue("Образцы получены по заявке № " . $requestid . " от " . $date);
              $sheet->getCell("P25")->setValue(mt_rand(421, 426)/10);
              $sheet->getCell("P26")->setValue(mt_rand(421, 426)/10);

              $sheet->getCell("R25")->setValue(mt_rand(564, 581)/10);
              $sheet->getCell("R26")->setValue(mt_rand(564, 581)/10);

              $sheet->getCell("Q25")->setValue('=ROUNDUP(SUM(P25*R25),0)');
              $sheet->getCell("Q26")->setValue('=ROUNDUP(SUM(P26*R26),0)');

            }

            $string = implode(", ", $weldArray);

            $sheet->getCell('B25')->setValue($string);


           })

           ->setFilename("331-3-17 72AN - " . uniqid('168 - 2.7 - 12Х18Н10Т _ ') . date("d.m.y")) // Per Query
           ->store('xlsx', storage_path('/app/exports/168 - 2.7 -12Х18Н10Т '.date('m-d-Y'))); // Per Query

      }
   }

   public static function createExcelFile10($exceldata)
   {

      $data = $exceldata->chunk(1);

      foreach ($data as $key)   {

        $path = storage_path('/app/excel/file10.xlsx');

          Excel::load($path, function($reader) use (&$key)
          {

            $objExcel = $reader->getExcel();

            $sheet = $objExcel->getSheet(0);

            foreach($key as $item => $value){

                $sheet->getCell('C25')->setValue($value->weld . ".1");
                $sheet->getCell('C26')->setValue($value->weld . ".2");
                $sheet->getCell('C27')->setValue($value->weld . ".3");
                $sheet->getCell('C28')->setValue($value->weld . ".4");
                $sheet->getCell('C29')->setValue($value->weld . ".5");
                $sheet->getCell('C30')->setValue($value->weld . ".6");
                $sheet->getCell('C31')->setValue($value->weld . ".7");

            }

            $weldArray = array();

            foreach($key as $item => $value) {

              $weldArray[] = $value->weld;

              $diameter = $value->diameter;
              $thicknes = $value->thicknes;
              $surname = $value->surname;
              $steelgrade = $value->steelgrade;
              $material = $value->material;
              $weldingdate = $value->weldingdate;
              $welderid = $value->welderid;
              $requestid = $value->requestid;
              $date = $value->documentdate;

              $sheet->getCell('J25')->setValue($diameter);
              $sheet->getCell('K25')->setValue($thicknes);
              $sheet->getCell('D25')->setValue($surname);
              $sheet->getCell('M25')->setValue($steelgrade . "/56");
              $sheet->getCell("N25")->setValue($material);
              $sheet->getCell("F25")->setValue($weldingdate);
              $sheet->getCell("E25")->setValue($welderid);
              $sheet->getCell("A15")->setValue("Образцы получены по заявке № " . $requestid . " от " . $date);
              $sheet->getCell("P25")->setValue(mt_rand(3501, 3504)/10);
              $sheet->getCell("P26")->setValue(mt_rand(3501, 3504)/10);

              $sheet->getCell("R25")->setValue(mt_rand(567, 578)/10);
              $sheet->getCell("R26")->setValue(mt_rand(567, 578)/10);

              $sheet->getCell("Q25")->setValue('=ROUNDUP(SUM(P25*R25),0)');
              $sheet->getCell("Q26")->setValue('=ROUNDUP(SUM(P26*R26),0)');

              $sheet->getCell("W29")->setValue(mt_rand(164, 192));
              $sheet->getCell("W30")->setValue(mt_rand(164, 192));
              $sheet->getCell("W31")->setValue(mt_rand(164, 192));

            }

            $string = implode(", ", $weldArray);

            $sheet->getCell('B25')->setValue($string);


           })

           ->setFilename("331-3-17 72AN - " . uniqid('300x300 - 14 - 09Г2С _ ') . date("d.m.y")) // Per Query
           ->store('xlsx', storage_path('/app/exports/300x300 - 14 -09Г2С '.date('m-d-Y'))); // Per Query

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
