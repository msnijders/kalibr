<?php

namespace App;

use Illuminate\Support\Facades\input;
use Illuminate\Database\Eloquent\Model;
use App\exceldatas;
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
     'documentdate'];
}
