<?php

namespace App\Http\Controllers;

use App\Services\ShopService;
use App\Shop;
use Exception;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    private $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    /**
     * Show All Shops.
     * @return \Illuminate\Http\Response
     */    
    public function index()
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->shopService->getAllShops();
        }catch(Exception $e){
            $result = [
                'status'=> 500,
                'error'=>$e->getMessage()
            ] ;
        }

        return response()->json($result, $result['status']);
    }

    public function disliked($id)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->shopService->disLikedShop($id);
        }catch(Exception $e){
            $result = [
                'status'=> 500,
                'error'=>$e->getMessage()
            ] ;
        }

        return response()->json($result, $result['status']);
    }

    public function removeDisliked($id)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->shopService->removeDisliked($id);
        }catch(Exception $e){
            $result = [
                'status'=> 500,
                'error'=>$e->getMessage()
            ] ;
        }

        return response()->json($result, $result['status']);
    }

    public function checkLogged()
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->shopService->checkLogged();
        }catch(Exception $e){
            $result = [
                'status'=> 401,
                'error'=>$e->getMessage()
            ] ;
        }

        return response()->json($result, $result['status']);
    }

}
