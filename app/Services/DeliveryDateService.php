<?php

namespace App\Services;

use Carbon\Carbon;

class DeliveryDateService
{
    // 最短配送日
    private $minDeliveryDays = 1;

    // プルダウンの選択数
    private $numOfChoices = 5;

    // 都道府県によって配送日をずらす設定
    private $prefectureDelay = ['北海道' => 2, '沖縄県' => 3];

    const DELAY_BORDER = '15:00';

    public function getDeliveryDates($currentDate, $orderTime, $prefecture)
    {
        $dates = [];
        $startDate = Carbon::parse($currentDate);
        $delay = $this->minDeliveryDays;

        // 15:00以降の注文であれば、最短配送日を1日後にずらす
        $isAfter15h = $orderTime >= self::DELAY_BORDER ? true : false;
        // 15:00以降の注文であれば、最短配送日を1日後にずらす
        if ($isAfter15h) {
            $delay += 1;
        }

        // 都道府県の選択でヒットしたら、その数値分配送日をずらす
        if (array_key_exists($prefecture, $this->prefectureDelay)) {
            $delay += $this->prefectureDelay[$prefecture];
        }

        // 配達可能日の最初の日を設定
        $startDate->addDays($delay);

        while (count($dates) < $this->numOfChoices) {
            // 土日は配送日から除外する
            $isWeekends = in_array($startDate->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY]);
            if ($isWeekends) {
                $startDate->addDay();
                continue;
            }

            $dates[] = $startDate->format('Y-m-d');
            $startDate->addDay();
        }

        return $dates;
    }
}
