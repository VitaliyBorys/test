<?php

namespace Tests\Unit;

use App\Models\Prize;
use App\Models\Setting;
use App\Service\PrizeService;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConvertTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
    }



    /** @test */
    public function testDefault(): void
    {
        /** @var  $service */
        $service = new PrizeService(new Prize(),Setting::getLimitMoneyValue());

        /** @var User $user */
        $user = factory(User::class)->create();

        $koef = 2;
        $bonus = 200;
        $user->addBonus($bonus);
        $service->convertBonusToMoney($user,$koef);
        self::assertEquals($user->money, $koef*$bonus);
    }


    /** @test  */
    public function testZeroBonus()
    {
        /** @var  $service */
        $service = new PrizeService(new Prize(),Setting::getLimitMoneyValue());

        /** @var User $user */
        $user = factory(User::class)->create();
        $koef = 2;

        $this->expectExceptionMessage('На вашем счету нету бонусов');
        $service->convertBonusToMoney($user,$koef);
    }
}
