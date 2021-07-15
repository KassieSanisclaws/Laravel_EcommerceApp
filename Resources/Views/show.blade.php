@extends('layouts.app')

@section('content')


<div class="container">
<div class="card">
    <div class="row">
        <aside class="col-sm-5 border-right">
<!--------------------------------------Below-First-Section-Card-Body------------------------------------------>
            <section class="gallery-wrap"> 
            <div class="img-big-wrap">
              <div> <a href="#">
                <img src="{{Storage::url($product->image)}}"  width="450" ></a>
              </div>
            </div>           
            </section> 
        </aside>
      <aside class="class-sm-7">
<!-------------------------------------Below-Second-Section-Card-Body------------------------------------------>
          <section class="card-body p-5">
              <h3 class="title mb-3">{{$product->name}}</h3>
              <hr>
              <p class="price-detail-wrap">
                <span class="price h3 text-primary">
                    <span class="currency">CAN: $
                    </span>{{$product->price}}
                </span>
              </p>
              <hr>

              <h3>Description</h3>
              <p>{!!$product->description!!}</p>
              <hr>
              <h3>Additional Information</h3>
              <p>{!!$product->additional_info!!}</p>
              <hr>

              <div class="row">
                 <div class="form-inline">
                    <h3>Quantity:</h3>
                    <input type="text" name="qty" class="form-control">
                    <input type="submit" class="btn btn-primary ml-2">
                 </div>
              </div>
                <hr>
                <a href="{{route('add.cart',[$product->id])}}" class="btn btn-lg btn-outline-primary text-uppercase">Add To Cart</a>
          </section>
        </aside>
    </div>
</div>
<!-----------------------------------------Below-Jumbotron-Container---------------------------------------------->
@if(count($productFromSameCategories)>0)
<div class="jumbotron">
  <h3> You May Also Like:</h3>
  <div class="row">

@foreach($productFromSameCategories as $product)
    <div class="col-md-4">
      <div class="card mb-4 shadow-sm">
        <img src="{{Storage::url($product->image)}}" height="280" style="width: 100%">
   <div class="card-body">
     <p><b>{{$product->name}}</b></p>
     <p class="card-text">{{Str::limit($product->descriptionm, 120)}}</p>
     <div class="d-flex justify-content-between align-items-center">
       <div class="btn-group">
         <a href="{{route('product.view',[$product->id])}}"><button type="button" class="btn btn-sm btn-outline-success">View</button></a>
         <a href="{{route('add.cart',[$product->id])}}"><button type="button" class="btn btn-sm btn-outline-primary">Add To Cart</button></a>
       </div>
       <small class="text-muted">${{$product->price}}</small>
     </div>
   </div>
</div>
</div>
@endforeach
</div>
</div>
</div>
@endif
</div>
@endsection