<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Seller;

class SellerController extends ApiController
{
    public function index()
    {
        $sellers = Seller::has('products')->get();
        return response()->json(['data' => $sellers], 200);
    }

    
    public function show($id){
        $seller = Seller::has('products')->findOrFail($id);
        return response()->json(['data' => $sellerApiController], 200);
    }

   
}
