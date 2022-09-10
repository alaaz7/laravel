<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\offerRequest;
use App\Traits\OfferTrait;
use App\Models\Offer;


class OfferController extends Controller
{
    use OfferTrait;

    public function create(){
        //view form to add this offer

        return view('ajaxoffers.create');
    }

    public function store(offerRequest $req){
        //save offer into DB using AJAX

        //save photo in folder
      $file_name = $this->saveImage($req->photo, 'images/offers');
     

      
      //insert into table offers in DB
      $offer = Offer::create([ 

           'photo' => $file_name,
           'name_ar' => $req -> name_ar,
           'name_en' => $req -> name_en,
           'price' => $req ->price,
           'details_en'=> $req -> details_en,
           'details_ar'=> $req -> details_ar,

  ]);

  if($offer)
  return response() -> json([
    'status' => true,
    'msg' => 'تم الحفظ بنجاح',
  ]);

  else
  return response() -> json([
    'status' => false,
    'msg' => 'عذرا يبدو ان هناك خطأ',
  ]);




    }
}
