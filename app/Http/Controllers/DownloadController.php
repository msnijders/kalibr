<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Exceldata;
use Zip;
use Response;

class DownloadController extends Controller
{

    public function main()
    {

      Exceldata::createExcelFile1($this->weld_1());
      Exceldata::createExcelFile2($this->weld_2());
      Exceldata::createExcelFile3($this->weld_3());
      Exceldata::createExcelFile4($this->weld_4());
      Exceldata::createExcelFile5($this->weld_5());
      Exceldata::createExcelFile6($this->weld_6());
      Exceldata::createExcelFile7($this->weld_7());
      Exceldata::createExcelFile8($this->weld_8());
      Exceldata::createExcelFile9($this->weld_9());
      Exceldata::createExcelFile10($this->weld_10());

      return $this->getDownload();

    }

    public function getDownload()
    {
      // Zipping
      $zip = Zip::create('export.zip');

      $zip->add(storage_path('/app/exports/', true));

      $zip->close();

      // Deleting files
      $path = 'exports/';

      Storage::deleteDirectory($path, true);

      // Downloading
      $file= public_path(). "/export.zip";

      $headers = array(
                'application/zip, application/octet-stream',
              );

      return Response::download($file, 'export.zip', $headers)->deleteFileAfterSend(true);

    }

    public function weld_1()
    {

      $exceldata = Exceldata::where([
        'diameter' => '21.3',
        'thicknes' => '2.5',
        'steelgrade' => 'Ст20',
      ])->get();

      return $exceldata;

    }

    public function weld_2()
    {

      $exceldata = Exceldata::where([
        'diameter' => '21.3',
        'thicknes' => '2.5',
        'steelgrade' => '12Х18Н10Т',
      ])->get();

      return $exceldata;

    }

    public function weld_3()
    {

      $exceldata = Exceldata::where([
        'diameter' => '60',
        'thicknes' => '4',
        'steelgrade' => 'Ст20',
      ])->get();

      return $exceldata;

    }

    public function weld_4()
    {

      $exceldata = Exceldata::where([
        'diameter' => '60',
        'thicknes' => '4',
        'steelgrade' => '12Х18Н10Т',
      ])->get();

      return $exceldata;

    }

    public function weld_5()
    {

      $exceldata = Exceldata::where([
        'diameter' => '168',
        'thicknes' => '12.7',
        'steelgrade' => 'Ст20',
      ])->get();

      return $exceldata;

    }

    public function weld_6()
    {

      $exceldata = Exceldata::where([
        'diameter' => '168',
        'thicknes' => '12.7',
        'steelgrade' => '12Х18Н10Т',
      ])->get();

      return $exceldata;

    }

    public function weld_7()
    {

      $exceldata = Exceldata::where([
        'diameter' => '168',
        'thicknes' => '7',
        'steelgrade' => 'Ст20',
      ])->get();

      return $exceldata;

    }

    public function weld_8()
    {

      $exceldata = Exceldata::where([
        'diameter' => '168',
        'thicknes' => '7',
        'steelgrade' => '12Х18Н10Т',
      ])->get();

      return $exceldata;

    }

    public function weld_9()
    {

      $exceldata = Exceldata::where([
        'diameter' => '168',
        'thicknes' => '2.7',
        'steelgrade' => '12Х18Н10Т',
      ])->get();

      return $exceldata;

    }

    public function weld_10()
    {

      $exceldata = Exceldata::where([
        'diameter' => '300х300',
        'thicknes' => '14',
        'steelgrade' => '09Г2С',
      ])->get();

      return $exceldata;

    }
}
