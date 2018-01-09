<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Exceldata;

class DownloadController extends Controller
{

    public function main()
    {

      // $exceldata = $this->data1();

      Exceldata::storeExcel($this->data1());

      // $exceldata2 = $this->data2();

      Exceldata::storeExcel($this->data2());



    }

    public function data1()
    {

      $exceldata = Exceldata::where([
        'diameter' => '21.3',
        'thicknes' => '2.5',
        'steelgrade' => '12Х18Н10Т',
      ])->get();

      return $exceldata;

    }

    public function data2()
    {

      $exceldata = Exceldata::where([
        'diameter' => '21.3',
        'thicknes' => '2.5',
        'steelgrade' => 'Ст20',
      ])->get();

      return $exceldata;

    }

}
