<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    /*Mostrar todos los productos en el index */
    public function index(){
        $products=Product::all();
        return response()->json($products);
    }

    /*
    Almancenar un nuevo registro
     */
    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'price'=>'required|numeric|min:0',
            'stock'=>'required|integer|min:0',
        ]);
        $product=Product::create($request->all());

        return response()->json($product,201); // 201 Created
    }
    /* Actualizar la información de un solo registro (id) */
    public function update(Request $request, Product $product){
        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'price'=>'required|numeric|min:0',
            'stock'=>'required|integer|min:0',
        ]);
        $product->update($request->all());

        return response()->json($product);

    }

    /* Mostrar la información de un registro(id) */
    public function show(Product $product){
        return response()->json($product);
    }

    /* Eliminar el registro de product */
    public function destroy(Product $product){
        $product->delete();
        return response()->json(null,204);// 204 No content
        
    }
}
