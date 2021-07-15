@extends('layouts.app')

@section('content')
      <div class="container">
        <main role="main">

          <div class="container">
            <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
      
        <div class="carousel-inner">
          @if(count($sliders)>0)
          @foreach($sliders as $key=> $slider)
      
          <div class="carousel-item {{$key == 0 ? 'active' : ''}}">
            <img src="{{Storage::url($slider->image)}}"  height="250" width="1500">
          </div>
          @endforeach
          @endif
         
        </div>
<!--------------------------------------------Below-Page-Header-Conatinaer-Carousel---------------------------------------------------->
    <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
   <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
         </div>
    </div>
    <hr>
<!-------------------------------------Below-Is-Category-Hearder-Links----------------------------------------------------->
          <h2>Category</h2>
      @foreach(App\Models\Category::all() as $cat)
      <a href="{{route('product.list',[$cat->slug])}}"> <button class="btn btn-secondary">{{$cat->name}}</button></a>
      @endforeach
<!-------------------------------------------------------------------------------------------------------------------------->
            <div class="album py-5 bg-light">
              <div class="container">
                <h2>Products</h2>
                    <div class="row">
<!---------------------------------------------Below-Is-The-Card-Body-------------------------------------------------->  
              @foreach($products as $product)
                    <div class="col-md-4">
                      <div class="card mb-4 shadow-sm">
              <img src="{{Storage::url($product->image)}}"  height="280" style="width: 100%">
                      <div class="card-body">
                        <p><b>{{$product->name}}</b></p>
                        <p class="card-text">{{Str::limit($product->description, 120)}}</p>
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="btn-group">
               <a href="{{route('product.view',[$product->id])}}"> <button type="button" class="btn btn-sm btn-outline-success">View</button></a>
               <a href="{{route('add.cart',[$product->id])}}"> <button type="button" class="btn btn-sm btn-outline-primary">Add To Cart</button></a>
                          </div>
                          <small class="text-muted">${{$product->price}}</small>
                        </div>
                      </div>
                    </div>
                  </div>
               @endforeach
                  </div>
               </div>
               <center>
                <a href="{{route('more.product')}}"><button class="btn btn-success">More Product</button>
                </a>
              </center>
          </div> 
<!------------------------------------------------Below-First-Carousel-Images-Sync----------------------------------------------->
    <div class="jumbotron">
       <div id="carouselExampleControls" Class="carousel slide" data-ride="carousel">
         <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="row">
          @foreach($randomActiveProducts as $product) 
               <div class="col-4">
                 <div class="card mb-4 shadow-sm">
                    <img src="{{Storage::url($product->image)}}" height="280" style="width: 100%">
                       <div class="card-body">
                           <p><b>{{$product->name}}</b></p>
                        <p class="card-text">{{(Str::limit($product->description,120))}}</p>
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="btn-group">
                            <a href="{{route('product.view',[$product->id])}}"> <button type="button" class="btn btn-sm btn-outline-success">View</button> </a>
                            <a href="{{route('add.cart',[$product->id])}}"> <button type="button" class="btn btn-sm btn-outline-primary">Add To Cart</button></a>
                          </div>
                          <small class="text-muted">${{$product->price}}</small>
                        </div>
                    </div>
                 </div>
               </div>
          @endforeach
          </div>
<!-------------------------------------------------------------------------------------------------------------------------->
        </div>
        <div class="carousel-item ">
          <div class="row">
            @foreach($randomItemProducts as $product)
    
            <div class="col-4">
              <div class="card mb-4 shadow-sm">
                <img src="{{Storage::url($product->image)}}" height="200" style="width: 100%">
                <div class="card-body">
                    <p><b>{{$product->name}}</b></p>
                  <p class="card-text">
                      {{(Str::limit($product->description,120))}}
                  </p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                    <a href="{{route('product.view',[$product->id])}}">  <button type="button" class="btn btn-sm btn-outline-success">View</button></a>
                     <a href="{{route('add.cart',[$product->id])}}"> 
                    <button type="button" class="btn btn-sm btn-outline-primary">Add to cart</button></a>
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
      <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>

       </main>
<!------------------------------------------Below-Footer----------------------------------------------------------------------->
          <footer class="text-muted py-5">
            <div class="container">
              <p class="float-end mb-1">
                <a href="#">Back to top</a>
              </p>
              
            </div>
          </footer>

    
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>copyright &copy; 2021 - developed by
              <b><a href="" target="_blank">Kassie Sanisclaws</a></b>
            </span>
          </div>
        </div>
      </footer>

<!-------------------------------Below-Scripts-For-Add-To-Cart-Function------------------------------------------------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
     $("document").ready(function(){
     $(".addToCart").click(function(e){
        e.preventDefault();
        var product = $(this).attr('id');
       // alert(product)
        $.ajax({
            //  headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            type: "GET",
            url: "http://localhost:8000/addToCart/"+product,
           // data: { product: product },
            success: function (data) {

            },
            error: function (data) {
             console.log(data)
            }
          });
     })


    });
</script>
@endsection