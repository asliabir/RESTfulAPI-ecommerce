<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerController extends Controller
{
    public function index(){
        $buyers = Buyer::has('transaction')->get();
        return response()->json(['data' => $buyers], 200);
    }


    public function show($id){
        $buyer = Buyer::has('transaction')->findOrFail($id);
        return response()->json(['data' => $buyer], 200);
    }

}
