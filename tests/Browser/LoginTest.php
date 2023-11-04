<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function testGeneral()
    {
        $this->browse(function ($browser) {
            $this->validate($browser);
            $this->loginByAdmin($browser);
            $this->loginByCustomer($browser);
//            $this->loginByRejectAccount($browser);
        });
    }

    public function validate($browser)
    {
        $browser->visit('/login?dtext=Validate_login&dstatus=0')
            ->waitFor('#login-page');

        $browser->typeSlowly('phone', '0394045475');
        //1.password null
//        $browser->press('.btn-submit')
//            ->waitfor('.notify--error')->assertSee('password không được để trống');
        //2. password incorrect
        $browser->typeSlowly('password', 123)->press('.btn-submit')
            ->waitfor('.notify--error')->assertSee('Sai tài khoản');
    }

    function loginByAdmin($browser)
    {
        $this->login($browser, ROLE_ADMIN, 'Login by Admin&dstatus=1')
            ->pause(1000)->assertSee('Đăng nhập thành công');
    }

    public function loginByCustomer($browser)
    {
        $this->login($browser, ROLE_CUSTOMER, 'Login by customer&dstatus=1')
            ->pause(2000)->assertSee('Đăng nhập thành công');
    }

    public function loginByRejectAccount($browser)
    {
        $browser->visit("/login?dtext=login by rejected Account&dstatus=1")
            ->pause(2000)->waitFor('#login-page')
            ->typeSlowly('phone', '0394045477')
            ->typeSlowly('password', '123456')->releaseMouse()->press('.btn-submit')
            ->waitFor('.notify--error')->assertSee('Sai tài khoản');
    }
}
