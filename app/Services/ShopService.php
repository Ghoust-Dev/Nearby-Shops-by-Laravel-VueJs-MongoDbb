<?php

namespace App\Services;

use App\Repositories\ShopRepositorie;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ShopService
{
    private $shopRepositorie;

    public function __construct(ShopRepositorie $shopRepositorie)
    {
        $this->shopRepositorie = $shopRepositorie;
    }

    public function getAllShops()
    {
        return $this->shopRepositorie->getAllShops();
    }

    public function disLikedShop($id)
    {
        return $this->shopRepositorie->disLikedShop($id);
    }

    public function removeDisliked($id)
    {
        return $this->shopRepositorie->removeDisliked($id);
    }

    public function checkLogged()
    {
        return $this->shopRepositorie->checkLogged();
    }
    
}
