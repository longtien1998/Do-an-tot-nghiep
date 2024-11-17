<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisements;
use PhpParser\Node\Stmt\TryCatch;

class AdvertisementsController extends Controller
{
    public function randomAds(){
        try{
            $ads = Advertisements::inRandomOrder()->first();
            return response()->json([
                'ads_name' => $ads->ads_name,
                'ads_description' => $ads->ads_description,
                'file_path' => $ads->file_path,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi tải quảng cáo ngẫu nhiên'], 500);

        }
    }
}
