<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        $product = \App\Models\Product::paginate(10);
        return view('pages.product.index', [
            'products'=>$product,
            'type_menu'=>'product'
        ]);
    }

    public function create(){
        return view('pages.product.create');
    }

    public function store(Request $request){
        $data = $request->all();
        \App\Models\Product::create($data);
        return redirect()->route('product.index')->with('success', 'Product Succesfully created');
    }

    public function edit($id){
        $product = \App\Models\Product::findOrFail($id);
        return view('pages.product.edit', [
            'product'=>$product,
            'type_menu'=>'product'
        ]);
    }

    public function update(Request $request,$id){
        $data = $request->all();
        $product = \App\Models\Product::findOrFail($id);
        $product->update($data);
        return redirect()->route('product.index')->with('success','Product Succesfully Update');
    }

    public function destroy($id){
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product Succesfully Update');
    }
}
