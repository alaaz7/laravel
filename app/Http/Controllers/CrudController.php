<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Offer;
use App\Traits\OfferTrait;
use App\Http\Requests\offerRequest;
use LaravelLocalization;
use App\Models\Video;
use App\Events\VideoViewer;
class CrudController extends Controller
{

    use OfferTrait;
    public function __construct()
    {
       
    }

    public function getOffers(){

      return  Offer::get(); // get all columns from database table offers
     // return  Offer::select('id','name')->get(); // to retreve specific columns in this method just
    }

    public function store(){

        Offer::create([
           'name' => 'offer2',
           'price'=> '5000',
           'details'=> 'offer detalis',

        ]);
    }
    public function create(){
        return view('offers.create');
    }

    public function save(offerRequest $req){ //Request $req درس تحسين الكود رقم 54
        
        //validate data befor insert to database
           // Validator take 3 params [request] [rules] [messages to return]
         //  $rules = $this->getRules();
         //  $msgs= $this->getMassges();
       // $validate = Validator::make($req->all(), $rules ,$msgs);

      //  if($validate -> fails()){
          //  return $validate -> errors(); // to return all errors was happend
         // return $validate -> errors() -> first(); // to return first error was happend
      //   return redirect()->back()->withErrors($validate)->withInputs($req->all());

      //  }

      //save photo in folder
      $file_name = $this->saveImage($req->photo, 'images/offers');
     

      
        //insert
        Offer::create([ 

             'photo' => $file_name,
             'name_ar' => $req -> name_ar,
             'name_en' => $req -> name_en,
             'price' => $req ->price,
             'details_en'=> $req -> details_en,
             'details_ar'=> $req -> details_ar,

    ]);
       // return 'data saved succssfuly';
       return redirect()->back()->with(['succss'=>__('messages.succss')]);
    }

   

 /*    protected function getMassges(){

        $msgs=[
            'name.required'=> trans('messages.offer name required'), // __() or trans() to select any lang you want to return message
            'price.required'=> __('messages.offer price required'),
            'details.required'=> __('messages.offer details required'),
            'name.unique'=> __('messages.offer name must be unique'),
            'price.numeric'=>__('messages.offer price must be numeric')

        
        ];
        return $msgs;
    }

    protected function getRules(){

        $rules = [

            'name' => 'required|max:100|unique:offers,name',
            'price'=> 'required|numeric',
            'details'=> 'required',

           ];
           return $rules;
    } */

    public function getAllOffers()
    {
       $offers = Offer::select('id',
            'price',
            'photo',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'details_' . LaravelLocalization::getCurrentLocale() . ' as details'
        )->get(); // return collection of all result

        return view('offers.all', compact('offers'));
    }

    public function editOffer($offer_id){

      //  offer::findOrFail($offer_id);
      $offer = offer::find($offer_id); // id only

      if(!$offer){
        return redirect()-> back();
      }
      $offer = Offer::select('id', 'name_ar', 'name_en', 'details_ar', 'details_en', 'price')->find($offer_id);

      return view('offers.edit', compact('offer'));
    }

    public function UpdateOffer(OfferRequest $request, $offer_id)
    {
        //validtion

        // chek if offer exists

        $offer = Offer::find($offer_id);
        if (!$offer)
            return redirect()->back();

        //update data

        $offer->update($request->all());

        return redirect()->back()->with(['succss' => __('messages.success')]);

        /*  $offer->update([
              'name_ar' => $request->name_ar,
              'name_en' => $request->name_en,
              'price' => $request->price,
          ]);*/

    }

    public function DeleteOffer($offer_id)
    {
        //check if offer id exists

        $offer = Offer::find($offer_id);   // Offer::where('id','$offer_id') -> first();

        if (!$offer)
            return redirect()->back()->with(['error' => __('messages.offer not exist')]);

        $offer->delete();

        return redirect()
            ->route('offers.all')
            ->with(['success' => __('messages.offer deleted successfully')]);

    }

    public function getVideo()
    {
        $video = Video::first();
        event(new VideoViewer($video)); //fire event
        return view('video')->with('video', $video);
    }
}
