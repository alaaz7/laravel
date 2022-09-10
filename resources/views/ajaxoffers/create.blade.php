@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <title>Bootstrap Example with Laravel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    .alaaStyle{
      height: 500px;
    }
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>
</head>
<body>


  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
    </div>
    <div class="col-sm-8 text-left"> 
      <h1>{{__('messages.welcome')}}</h1>
<p>{{__('messages.Add new Offer')}}</p>
<br>
@if(Session::has('succss'))
<div class="alert alert-success" role="alert">
{{Session::get('succss')}}
</div>
@endif

<div class="alert alert-success" id="sucssid" role="alert" style="display:none">
  تم الحفظ بنجاح
  </div>
<form class="form-horizontal" id="offerForm" method="POST" action="" enctype="multipart/form-data">
    @csrf 
   <!-- <input name="_token" value="{{csrf_token()}}"> -->
   
   <div class="form-group">
   <label for="exampleInputEmail1">أختر صوره العرض</label>
      <div class="col-sm-10">
        <input type="file" class="form-control" id="photo"  name="photo">
        @error('photo')
        <small class="form-text text-danger">{{$message}}</small>
        @enderror
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="email">{{__('messages.Offer Name ar')}}:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="name_ar" placeholder="{{__('messages.Offer Name')}}" name="name_ar">
        @error('name_ar')
        <small class="form-text text-danger">{{$message}}</small>
        @enderror
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="email">{{__('messages.Offer Name en')}}:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="name_en" placeholder="{{__('messages.Offer Name')}}" name="name_en">
        @error('name_en')
        <small class="form-text text-danger">{{$message}}</small>
        @enderror
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">{{__('messages.Offer Price ar')}}:</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="price" placeholder="{{__('messages.Offer Price')}}" name="price">
        @error('price')
        <small class="form-text text-danger">{{$message}}</small>
        @enderror
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">{{__('messages.Offer Details ar')}}:</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="details_ar" placeholder="{{__('messages.Offer Details')}}" name="details_ar">
        @error('details_ar')
        <small class="form-text text-danger">{{$message}}</small>
        @enderror
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">{{__('messages.Offer Details en')}}:</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="details_en" placeholder="{{__('messages.Offer Details')}}" name="details_en">
        @error('details_en')
        <small class="form-text text-danger">{{$message}}</small>
        @enderror
      </div>
    </div>
   
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button id="save_offer" class="btn btn-primary">{{__('messages.Save')}}</button>
      </div>
    </div>
  </form>
      <hr>
      <h3>Test</h3>
      <p>Lorem ipsum...</p>
    </div>
    <div class="col-sm-2 sidenav">
      <div class="well">
        <p>ADS</p>
      </div>
      <div class="well">
        <p>ADS</p>
      </div>
    </div>
  </div>
</div>


</body>
</html>

 
@stop

@section('scripts')

   <script>
           
           $(document).on('click','#save_offer',function(e){

            e.preventDefault();

            var formData = new FormData($('#offerForm')[0]);
            $.ajax({
              type: 'post',
              enctype: 'multipart/form-data', // for photo or file
              url:"{{route('ajax-offers.store')}}",
              data: formData,
              processData: false,
              contentType: false,
              cache:false,
              success: function (data){
                if(data.status == true || false)
                //alert(data.msg);
                $('#sucssid').show();

              },
              error: function (reject){

              }

           });



           });

          
   </script>

@stop