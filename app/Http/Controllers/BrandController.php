<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Multipic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function AllBrand()
    {
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brands'));
    }
    public function StoreBrand(Request $request)
    {
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|max:255',
            'brand_image' => 'required|mimes:jpeg,png,jpg'
        ],[
            'brand_name.required' => 'Please Input Brand Name',
            'beand_name.max' => 'Category more Than 255Chars'

        ]);

        $brand_image = $request->file('brand_image');

/*         $name_gen = hexdec(uniqid());
        $img_ext =  strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen . '.' . $img_ext;
        $up_location = 'image/brand/';
        $last_img = $up_location . $img_name;
        $brand_image->move($up_location, $img_name); */

        $name_gen = hexdec(uniqid()). '.'. $brand_image->getClientOriginalExtension();
        Image::make($brand_image)->resize(300, 200)->save('image/brand/'. $name_gen);
        $last_img = 'image/brand/' . $name_gen;

        Brand::create([
            'brand_name' => $validated['brand_name'],
            'brand_image' => $last_img
        ]);

        return redirect()->back()->with('success', 'Brand inserted successfully');
    }

    public function Edit($id)
    {
        $brand = Brand::findOrFail($id);

        return view('admin.brand.edit',compact('brand'));
    }

    public function Update(Request $request, $id)
    {
        $validated = $request->validate([
            'brand_name' => 'required|max:255',
        ],[
            'brand_name.required' => 'Please Input Brand Name',
            'beand_name.max' => 'Category more Than 255Chars'

        ]);
        $old_image = $request->old_image;
        $brand_image = $request->file('brand_image');
        if($brand_image){

             $name_gen = hexdec(uniqid()). '.'. $brand_image->getClientOriginalExtension();
            /*$img_ext =  strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_gen . '.' . $img_ext;
            $up_location = 'image/brand/';
            $last_img = $up_location . $img_name;
            $brand_image->move($up_location, $img_name); */
            Image::make($brand_image)->resize(300, 200)->save('image/brand/'. $name_gen);

            $last_img = 'image/brand/' . $name_gen;

            unlink($old_image);
            Brand::find($id)->update([
                'brand_name' => $validated['brand_name'],
                'brand_image' => $last_img
            ]);

            return redirect()->back()->with('success', 'Brand updated successfully');
        }

        Brand::find($id)->update([
            'brand_name' => $validated['brand_name']
        ]);

        return redirect()->back()->with('success', 'Brand updated successfully');


    }
    public function Delete($id)
    {
        $image = Brand::find($id);
        $old_image = $image->brand_image;
        unlink($old_image);

        Brand::find($id)->delete();
        return redirect()->back()->with('success', 'Brand deleted successfully');

    }
    // multi image all method
    public function Multpic()
    {
        $images = Multipic::all();
        return view('admin.multipic.index',compact('images'));
    }

    public function StoreImg(Request $request)
    {
        $image = $request->file('image');

        foreach($image as $multi_img){

            $name_gen = hexdec(uniqid()). '.'. $multi_img->getClientOriginalExtension();
            Image::make($multi_img)->resize(300, 300)->save('image/multi/'. $name_gen);
            $last_img = 'image/multi/' . $name_gen;

            Multipic::create([
                'image' => $last_img,
            ]);
        }

        return redirect()->back()->with('success', 'Brand inserted successfully');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('success', 'User Logout');
    }

}
