<?php

namespace App\Repositories;

use App\Shop;
use DateTime;
use Illuminate\Support\Facades\Auth;

class ShopRepositorie
{
    public function getAllShops()
    {
        return Shop::all();
    }

    public function disLikedShop($id)
    {
        $shop = Shop::find($id);

        $timeDisliked = new DateTime();

        $shop->Disliked = true;
        $shop->timeDisliked = $timeDisliked->getTimestamp()+7200000;

        $shop->save();
    }

    public function removeDisliked($id)
    {
        $shop = Shop::find($id);
        
        $shop->unset('Disliked');
        $shop->unset('timeDisliked');
        
    }

    public function checkLogged()
    {
        return Auth::User()->name;
        
    }
}
