<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catagory;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function view_catagory()
    {
        $catagories = Catagory::all();
        return view('admin.catagory', compact('catagories'));
    }

    public function add_catagory(Request $request)
    {
        $catagory = new Catagory;
        $catagory->catagory_name = $request->catagory_name;
        $catagory->save();
        return redirect()->back()->with('message', 'Category added successfully');
    }

    public function delete_catagory($id)
    {
        $catagory = Catagory::find($id);
        $catagory->delete();
        return redirect()->back()->with('message', 'Category deleted successfully');
    }

    public function view_product()
    {
        $catagories = Catagory::all();
        return view('admin.product', compact('catagories'));
    }

    public function ajaxAddProduct(Request $request)
    {
        $product = new Product;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->discount_price = $request->dis_price;
        $product->catagory = $request->catagory;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('product', $imagename);
            $product->image = $imagename;
        }

        $product->save();

        return response()->json(['success' => 'Product Added Successfully']);
    }

    public function show_product()
    {
        $products = Product::all();
        return view('admin.show_product', compact('products'));
    }

    public function delete_product($id)
    {
        $product = Product::find($id);

        if ($product->image) {
            unlink(public_path('product/' . $product->image));
        }

        $product->delete();
        return redirect()->back()->with('message', 'Product deleted successfully');
    }

    public function update_product($id)
    {
        $product = Product::find($id);
        $catagories = Catagory::all();
        return view('admin.update_product', compact('product', 'catagories'));
    }

    public function update_product_confirm(Request $request, $id)
    {
        $product = Product::find($id);
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->discount_price = $request->dis_price;
        $product->catagory = $request->catagory;

        if ($request->hasFile('image')) {
            if ($product->image) {
                unlink(public_path('product/' . $product->image));
            }

            $image = $request->file('image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('product', $imagename);
            $product->image = $imagename;
        }

        $product->save();
        return redirect('/show_product')->with('message', 'Product updated successfully');
    }

    public function ajaxSearchProduct(Request $request)
    {
        $query = $request->query('query');
        $products = Product::where('title', 'LIKE', "%{$query}%")
            ->orWhere('catagory', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($products);
    }

    public function order()
    {
        // Placeholder for order logic
    }

    public function delivered($id)
    {
        // Placeholder for delivered logic
    }

    public function print_pdf($id)
    {
        // Placeholder for print PDF logic
    }

    public function send_email($id)
    {
        // Placeholder for email sending logic
    }

    public function send_user_email(Request $request, $id)
    {
        // Placeholder for sending user email logic
    }

    public function searchdata(Request $request)
    {
        $search = $request->search;
        $data = Product::where('title', 'LIKE', "%$search%")
            ->orWhere('catagory', 'LIKE', "%$search%")
            ->get();

        return view('admin.show_product', compact('data'));
    }
}
