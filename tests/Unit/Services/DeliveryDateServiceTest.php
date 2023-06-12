<?php

namespace Tests\Unit\Services;

use Carbon\Carbon;
use Tests\TestCase;
use App\Services\DeliveryDateService;

class DeliveryDateServiceTest extends TestCase
{
    protected $deliveryDateService;

    public function setUp(): void
    {
        parent::setUp();
        $this->deliveryDateService = new DeliveryDateService();
    }

    /**
     * 15:00以前・本州（九州・四国含む）のテスト
     *
     * @return void
     */
    public function testDeliveryDatesBefore15h(): void
    {
        $dates = $this->deliveryDateService->getDeliveryDates(
            Carbon::parse('2023-06-11'),
            '14:59',
            '東京都'
        );

        $this->assertCount(5, $dates); // 日付の選択肢の取得
        $this->assertEquals('2023-06-12', $dates[0]); // 最短の日付のテスト
        $this->assertEquals('2023-06-13', $dates[1]); // 翌日の日付のテスト

        // 北海道
        $dates = $this->deliveryDateService->getDeliveryDates(
            Carbon::parse('2023-06-11'),
            '14:59',
            '北海道'
        );

        $this->assertCount(5, $dates); // 日付の選択肢の取得
        $this->assertEquals('2023-06-14', $dates[0]); // 最短の日付のテスト
        $this->assertEquals('2023-06-15', $dates[1]); // 翌日の日付のテスト

        // 沖縄
        $dates = $this->deliveryDateService->getDeliveryDates(
            Carbon::parse('2023-06-11'),
            '14:59',
            '沖縄県'
        );

        $this->assertCount(5, $dates); // 日付の選択肢の取得
        $this->assertEquals('2023-06-15', $dates[0]); // 最短の日付のテスト
        $this->assertEquals('2023-06-16', $dates[1]); // 翌日の日付のテスト
    }

    /**
     * 15:00以以降・本州（九州・四国含む）のテスト
     *
     * @return void
     */
    public function testDeliveryDatesAfter15h(): void
    {
        $dates = $this->deliveryDateService->getDeliveryDates(
            Carbon::parse('2023-06-11'),
            DeliveryDateService::DELAY_BORDER,
            '東京都'
        );

        $this->assertCount(5, $dates); // 日付の選択肢の取得
        $this->assertEquals('2023-06-13', $dates[0]); // 最短の日付のテスト
        $this->assertEquals('2023-06-14', $dates[1]); // 翌日の日付のテスト

        // 北海道
        $dates = $this->deliveryDateService->getDeliveryDates(
            Carbon::parse('2023-06-11'),
            DeliveryDateService::DELAY_BORDER,
            '北海道'
        );

        $this->assertCount(5, $dates); // 日付の選択肢の取得
        $this->assertEquals('2023-06-15', $dates[0]); // 最短の日付のテスト
        $this->assertEquals('2023-06-16', $dates[1]); // 翌日の日付のテスト

        // 沖縄
        $dates = $this->deliveryDateService->getDeliveryDates(
            Carbon::parse('2023-06-11'),
            DeliveryDateService::DELAY_BORDER,
            '沖縄県'
        );

        $this->assertCount(5, $dates); // 日付の選択肢の取得
        $this->assertEquals('2023-06-16', $dates[0]); // 最短の日付のテスト
        $this->assertEquals('2023-06-19', $dates[1]); // 翌日の日付のテスト（土日挟むので19日でOK）
    }
}
