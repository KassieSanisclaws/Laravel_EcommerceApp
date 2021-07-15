@extends('admin.layouts.main') <!--this line here extends the layout from the admin-layout-folder-dashboard.blade.php and is rooted in the public-admin-folder-all-styling.-->

@section('content')  <!---this line starts the build of the page-this is needed at the begining of all pages.---->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 ml-4 text-gray-800">SubCategory</h1>
     <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="./">Home</a></li>
         <li class="breadcrumb-item active" aria-current="page">SubCategory</li>
     </ol>
 </div>
 <div class="row justify-content-center">
<!---------------------The-below-is-how-you-display-the-redirect-message-of-successful-category-created.----------------->
     @if(Session::has('message'))
       <div class="alert alert-success">{{Session::get('message')}}</div>
    @endif

       <div class="col-lg-10">
<!--------------------------------------------------Form-Start-Here------------------------------------------------------------------------------------>
    <form action="{{route('subcategory.update', [$subcategory->id])}}" method="POST">@csrf
        {{method_field('PUT')}}
        <div class="card m-6">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">UpDate SubCategory</h6>
            </div>

            <div class="card-body">
                <div class="form-group"> 
                  <label for="">Name</label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror " id="" aria-describedby="" value="{{$subcategory->name}}">
<!-----------------------------------Display-Error-Message----------------------------------------------->
                    @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
<!-----------------------------^-Error-Message-End-Here-^------------------------------------------->
                </div>
                
            <div class="form-group">
                <div class="custom-file">
                    <label>Choose Category</label>
                    <select name="category" class="form-control @error('category') is-invalid @enderror">
                        <option value="">Select Category</option>
                @foreach(App\Models\Category::all() as $category)
                    <option value="{{$category->id}}" @if($subcategory->category_id == $category->id) selected @endif>{{$category->name}}</option>
                @endforeach
                 </select>

                 @error('category')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                @enderror
<!-----------------------------------Display-Error-Message-------------------------------------------------->
                   
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
<!---------------------------------------^-Form-Ends-Here-^----------------------------------------------------->
 </div>
</div>
@endsection