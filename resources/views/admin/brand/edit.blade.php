@extends('admin.admin_master')
@section('admin')

    <div class="py-12">
        <div class="container">
            <div class="row">

                <div class="col-md-8">
                    <div class="card">

                        @if ($message = session('success'))
                        <div class="alert alert-success" role="alert">
                            {{$message}}
                        </div>
                        @endif

                        <div class="card-header">Edit Brand</div>
                        <div class="card-body">

                            <form action="{{url('brand/update/'. $brand->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="old_image" value="{{$brand->brand_image}}" />
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Update Brand Name</label>
                                    <input name="brand_name" value="{{ $brand->brand_name }}" type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp">
                                    @error('brand_name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Update Brand Image</label>
                                    <input name="brand_image" value="{{ $brand->brand_image }}" type="file" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp">
                                    @error('brand_image')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <img src="{{asset($brand->brand_image)}}" style="width: 400px" height="200px" alt="">
                                </div>

                                <button type="submit" class="btn btn-primary btn-outline-primary">Update Brand</button>
                            </form>
                        </div>


                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
