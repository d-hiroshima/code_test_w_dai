<?php

namespace App\Http\Controllers;

use App\Services\DeliveryDateService;

class OrderController extends Controller
{
    public function index()
    {
        $deliveryDateService = new DeliveryDateService();
        $deliveryArea = $deliveryDateService::DELIVERY_AREA;
        return view('index', compact('deliveryArea'));
    }

    public function getDate($deliveryArea)
    {
        $deliveryDateService = new DeliveryDateService();
        $dates = $deliveryDateService->getDeliveryDates(date('Y-m-d'), date('H:i'), $deliveryArea);
        return response()->json($dates);
    }
}
