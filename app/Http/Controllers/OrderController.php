<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeliveryDateService;

class OrderController extends Controller
{
    public function index()
    {
        $deliveryDateService = new DeliveryDateService();
        return view('index', compact($deliveryDateService));
    }

    public function getDate($deliveryArea)
    {
        $deliveryDateService = new DeliveryDateService();
        $dates = $deliveryDateService->getDeliveryDates(date('Y-m-d'), date('H:i'), $deliveryArea);
        return response()->json($dates);
    }
}
