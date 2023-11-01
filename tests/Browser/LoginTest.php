<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->typeSlowly('phone', '0394045475')
                ->typeSlowly('password', '123456')
                ->press('.btn-submit')
                ->waitFor('.notify--success')
                ->assertSee('Đăng nhập thành công');
        });
    }
}
