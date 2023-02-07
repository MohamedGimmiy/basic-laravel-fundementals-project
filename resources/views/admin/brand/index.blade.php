
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
                        <div class="card-header">All Brand</div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">SL NO</th>
                                    <th scope="col">Brand Name</th>
                                    <th scope="col">Brand Image</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $brand)
                                <tr>
                                    <th scope="row">{{ $brands->firstItem()+$loop->index}}</th>
                                    <td>{{$brand->brand_name}}</td>
                                    <td>
                                        <img src="{{asset($brand->brand_image)}}" style="height: 40px; width:70px;" alt="">
                                    </td>
                                    <td>
                                        @if ($brand->created_at == NULL)
                                        <span class="text-danger">No Date Set</span>
                                        @else

                                        {{ Carbon\Carbon::parse($brand->created_at)->diffForHumans()}}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('brand/edit/' .$brand->id)}}" class="btn btn-info">Edit</a>
                                        <a href="{{url('brand/delete/'.$brand->id)}}" onclick="confirm('Are you sure to delete?')" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$brands->links()}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Add Brand</div>
                        <div class="card-body">

                            <form action="{{route('store.brand')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Brand Name</label>
                                    <input name="brand_name" type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp">
                                    @error('brand_name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Brand Image</label>
                                    <input name="brand_image" type="file" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp">
                                    @error('brand_image')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-outline-primary">Add Brand </button>
                            </form>
                        </div>


                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
