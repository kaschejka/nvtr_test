<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class siteController extends Controller
{
    public function book(Request $req)
    {
      $i = rand(0,1);
      if ($i == 1) {
          return [ "message" => 'order successfully booked'];
      } else {
        return ["error" => 'barcode already exists'];
      }


    }
    public function approve(Request $req)
    {
      $i = rand(0,4);
      switch ($i) {
    case 0:
        return [ "message" => 'order successfully approved'];

    case 1:
        return ["error" => 'event cancelled'];

    case 2:
        return ["error" => 'no tickets'];

    case 3:
        return ["error" => 'no seats'];
        
}

    }
}
