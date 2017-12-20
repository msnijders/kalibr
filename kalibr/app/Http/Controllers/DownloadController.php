<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Exceldata;

class DownloadController extends Controller
{

    public function main()
    {

      // $exceldata = Exceldata::where([
      //   'diameter' => '21.3',
      //   'thicknes' => '2.5',
      //   'steelgrade' => 'Ст20',
      //
      //   ])->get();

      $exceldata = $this->data1();


      return Exceldata::getData($exceldata);


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

}
