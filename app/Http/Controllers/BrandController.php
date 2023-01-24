<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{

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

        $name_gen = hexdec(uniqid());
        $img_ext =  strtolower($brand_image->getClientOriginalExtension());

        $img_name = $name_gen . '.' . $img_ext;
        $up_location = 'image/brand/';
        $last_img = $up_location . $img_name;
        $brand_image->move($up_location, $img_name);

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
}
