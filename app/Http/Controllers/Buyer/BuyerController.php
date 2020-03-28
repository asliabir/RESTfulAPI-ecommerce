<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerController extends ApiController
{
    public function index(){
        $buyers = Buyer::has('transaction')->get();
        return $this->showAll($buyers);
    }

    public function show($id){
        $buyer = Buyer::has('transaction')->findOrFail($id);
        return $this->showOne($buyer);
    }

}
