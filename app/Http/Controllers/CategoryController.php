<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function AllCat()
    {
/*         $categories = DB::table('categories')->join('users', 'categories.user_id', 'users.id')
            ->select('categories.*', 'users.name')->latest()->paginate(2); */
        $categories = Category::latest()->paginate(3);

        $trashCat = Category::onlyTrashed()->latest()->paginate(3);
        //$categories = DB::table('categories')->latest()->paginate(1);
        return view('admin.category.index',compact('categories', 'trashCat'));
    }

    public function AddCat(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255'
        ],[
            'category_name.required' => 'Please Input Category Name',
            'category_name.max' => 'Category more Than 255Chars'

        ]);

        Category::create([
            'category_name' => $validated['category_name'],
            'user_id' => Auth::user()->id
        ]);
/*         DB::table('categories')->insert([
            'category_name' => $validated['category_name'],
            'user_id' => Auth::user()->id
        ]); */

        return redirect()->back()->with('success', 'Category Inserted Successfully!');
    }


    public function Edit($id)
    {
        $categories = Category::findOrFail($id);

        return view('admin.category.edit', compact('categories'));
    }

    public function Update(Request $request, $id)
    {
        $update = Category::findOrFail($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('category.all')->with('success', 'Category Updated Successfully!');
    }

    public function SoftDelete($id)
    {
        $delete = Category::find($id)->delete();

        return redirect()->back()->with('success', 'Category Soft deleted successfully!');
    }

    public function Restore($id)
    {
        $delete = Category::withTrashed()->find($id)->restore();

        return redirect()->back()->with('success', 'Category restored successfully!');

    }
    public function Pdelete($id)
    {
        $delete = Category::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success', 'Category permanently deleted successfully!');
    }
}
