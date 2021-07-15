@extends('admin.layouts.main') <!--this line here extends the layout from the admin-layout-folder-dashboard.blade.php and is rooted in the public-admin-folder-all-styling.-->

@section('content')  <!---this line starts the build of the page-this is needed at the begining of all pages.---->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 ml-4 text-gray-800">Product</h1>
     <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="./">Home</a></li>
         <li class="breadcrumb-item active" aria-current="page">Products</li>
     </ol>
 </div>
 <div class="row justify-content-center">
<!---------------------The-below-is-how-you-display-the-redirect-message-of-successful-category-created.----------------->
     @if(Session::has('message'))
       <div class="alert alert-success">{{Session::get('message')}}</div>
    @endif

       <div class="col-lg-10">
<!--------------------------------------------------Form-Start-Here------------------------------------------------------------------------------------>
    <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">@csrf
        <div class="card m-6">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Create Product</h6>
            </div>

            <div class="card-body">
                <div class="form-group"> 
                  <label for="">Name</label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror " id="" aria-describedby="" placeholder="Enter name of Product">
<!-----------------------------------Display-Error-Message----------------------------------------------->
                    @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
<!-----------------------------^-Error-Message-End-Here-^------------------------------------------->
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                <textarea name="description" id="summernote" class="form-control @error('description') is-invalid @enderror"></textarea>
<!-------------------------------Error-Message------------------------------------------------------>
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                </div>
            <div class="form=group">
                <label>Image</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="customFile" name="image">
                    <label class="custom-file-label" for="customFile">Choose File</label>
<!-----------------------------------Display-Error-Message-------------------------------------------------->
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
<!---------------------------^--Error-Message-End-Here-^--------------------------------------------->
                </div>
            </div>
<!-----------------------------------------Below-Price-Form-Information-------------------------------------------------------------->
            <br>
          <div class="form-group">
            <label for="">Price($)</label>
            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="" aria-describedby="">
            @error('name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
            @enderror
          </div>
<!--------------------------------------Below-Additonal-Information----------------------------------------------------------->
          <div class="form-group">
              <label for="">Additional Information</label>
              <textarea name="additional_info" id="summernote1" class="form-control @error('additional_info') is-invalid @enderror"></textarea>
            @error('additional_info')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
          </div>
<!-----------------------------------------Below-Choose-Category---------------------------------------------------------------->
           <div class="form-group">
               <label for="">Choose Category</label>
               <select name="category" class="form-control @error('category') is-invalid @enderror">
                <option value="">select</option>
            @foreach(App\Models\Category::all() as $category)  
               <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
               </select>
            @error('category')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
           </div>
<!-------------------------------------------Below-Subcategory-Form-------------------------------------------------------------------->
         <div class="form-group">
             <label for="">Choose Subcategory</label>
              <select name="subcategory" class="form-control @error('subcategory') is-invalid @enderror">
                <option value="">Select</option>
           @foreach(App\Models\Subcategory::all() as $subcategory)
               <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
           @endforeach
              </select>
           @error('subcategory')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
         </div>
<!--------------------------------------Below-Submit-Button----------------------------------------------------------------->
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
<!---------------------------------------^-Form-Ends-Here-^----------------------------------------------------->
 </div>
</div>

<!----------------------------Below -Checks-The-Change-Of-The-Category-Selected------------------------------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">$("document").ready(function(){
                               $('select[name="category"]').on('change', function(){
                                   var catId = $(this).val();
                                   if(catId){
                                       $.ajax({url:'/subcategories/'+ catId, type:"GET", dataType:"json", success:function(data){ 
                                           $('select[name="subcategory"]').empty();
                                           $.each(data, function(key,value){
                                           $('select[name="subcategory"]').append('<option value=" '+key+'">'+value+'</option>');
                                           });
                                         }                         
                                     });
                                   }else{
                                     $('select[name="subcategory"]').empty(); 
                                   }
                               });


});
</script>
@endsection