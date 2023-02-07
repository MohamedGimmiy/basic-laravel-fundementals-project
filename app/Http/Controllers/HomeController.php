<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    public function HomeSlider(){
        $sliders = Slider::latest()->get();
        return view('admin.slider.index',compact('sliders'));
    }

    public function AddSlider(){
        return view('admin.slider.create');
    }

    public function StoreSlider(Request $request){
        $slider_image = $request->file('image');

/*         $name_gen = hexdec(uniqid());
        $img_ext =  strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen . '.' . $img_ext;
        $up_location = 'image/brand/';
        $last_img = $up_location . $img_name;
        $brand_image->move($up_location, $img_name); */

        $name_gen = hexdec(uniqid()). '.'. $slider_image->getClientOriginalExtension();
        Image::make($slider_image)->resize(300, 200)->save('image/slider/'. $name_gen);
        $last_img = 'image/slider/' . $name_gen;

        Slider::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $last_img
        ]);

        return redirect()->route('home.slider')->with('success', 'Slider inserted successfully');
    }


    public function Edit($id){
        $slider = Slider::findOrFail($id);
        return view('admin\slider\edit', compact('slider'));
    }

    public function Update(Request $request, $id)
    {
        $old_image = $request->old_image;
        $image = $request->file('image');
        if ($image) {

            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            /*$img_ext =  strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_gen . '.' . $img_ext;
            $up_location = 'image/brand/';
            $last_img = $up_location . $img_name;
            $brand_image->move($up_location, $img_name); */
            Image::make($image)->resize(300, 200)->save('image/slider/' . $name_gen);

            $last_img = 'image/slider/' . $name_gen;

            unlink($old_image);
            Slider::find($id)->update([
                'title' => $request->title,
                'image' => $last_img
            ]);

            return redirect()->back()->with('success', 'Slider updated successfully');
        }
        Slider::find($id)->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect()->back()->with('success', 'Slider updated successfully');
    }
    public function Delete($id){
        $slider = Slider::find($id);
        $old_image = $slider->image;
        unlink($old_image);

        $slider->delete();
        return redirect()->back()->with('success', 'Slider deleted successfully');
    }
}
