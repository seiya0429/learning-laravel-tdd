<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Lesson;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{    
    /**
     * testCanReserve
     *
     * @param  string $plan
     * @param  int $remainingCount
     * @param  int $reservationCount
     * @param  bool $canReserve
     * @dataProvider dataCanReserve
     */
    public function testCanReserve(string $plan, int $remainingCount, int $reservationCount, bool $canReserve)
    {
        $user = new User();
        $user->plan = $plan;

        $lesson = new Lesson();

        $this->assertSame($canReserve, $user->canReserve($lesson->remainingCount(), $reservationCount));
    }

    public function dataCanReserve()
    {
        return [
            '予約可:レギュラー、空きあり、月の上限以下' => [
                'plan' => 'regular',
                'remainingCout' => 1,
                'reservationCount' => 4,
                'canReserve' => true
            ],
            '予約不可:レギュラー、空きあり、月の上限' => [
                'plan' => 'regular',
                'remainingCout' => 1,
                'reservationCount' => 5,
                'canReserve' => false
            ],
            '予約不可:レギュラー、空きなし、月の上限' => [
                'plan' => 'regular',
                'remainingCout' => 0,
                'reservationCount' => 0,
                'canReserve' => false
            ],
            '予約可:ゴールド、空きあり、月の上限' => [
                'plan' => 'gold',
                'remainingCout' => 1,
                'reservationCount' => 0,
                'canReserve' => true
            ],
            '予約不可:ゴールド、空きなし、月の上限' => [
                'plan' => 'gold',
                'remainingCout' => 0,
                'reservationCount' => 0,
                'canReserve' => false
            ],
        ];
    }
}
