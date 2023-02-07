@extends('admin.admin_master')
@section('admin')
<div class="col-lg-12">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom">
            <h2>edit slider</h2>
        </div>
        <div class="card-body">
            <form action="{{url('slider/update/' . $slider->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="old_image" value="{{$slider->image}}" />

                <div class="form-group">
                    <label for="exampleFormControlInput1">slider title</label>
                    <input type="text" value="{{old('title',$slider->title)}}" name="title" class="form-control" id="exampleFormControlInput1" placeholder="slider title">
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Slider description</label>
                    <textarea class="form-control"  id="exampleFormControlTextarea1" name="description" rows="3">
                        {{old('description',$slider->description)}}
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Image</label>
                    <input type="file" name="image" value="{{old('image',$slider->image)}}" class="form-control-file" id="exampleFormControlFile1">
                </div>
                <div class="form-footer pt-4 pt-5 mt-4 border-top">
                    <button type="submit" class="btn btn-primary btn-default">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
