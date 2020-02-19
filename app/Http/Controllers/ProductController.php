<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search = $request->search;
        $criterion = $request->criterion;


        if ($search=='') {
            $products = Product::orderBy('id', 'desc')->paginate(7);
        } else {
            $products = Product::where($criterion, 'like', '%'. $search . '%')
            ->orderBy('id', 'desc')->paginate(7);

        }


        return [
            'pagination' => [
                'total'         => $products->total(),
                'current_page'  => $products->currentPage(),
                'per_page'      => $products->perPage(),
                'last_page'     => $products->lastPage(),
                'from'          => $products->firstItem(),
                'to'            => $products->lastItem(),
            ],
            'products' => $products
        ];
    }

    
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->stock = $request->stock;
        $product->store = $request->store;
        $product->status = '1';
        $product->save();

    }


    public function desactive(Request $request)
    {
        
        $product = Product::findOrFail($request->id);

        $product->status = '0';
        $product->save();
    }

    public function active(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $product->status = '1';
        $product->save();
    }
}
