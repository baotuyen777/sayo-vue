<?php

namespace Tests\Browser;

use App\Models\Files;
use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PostTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testGeneral()
    {
        $this->browse(function ($browser) {
            $this->login($browser);
            $this->validate($browser);
//            $this->editPost($browser);
//            $this->approvePost($browser);
//            $this->deletePost($browser);
//            $browser->visit('/login?dtext=Test login&dstatus=1')->waitFor('#login-page');
//            $this->validate($browser);

//            $this->loginByAdmin($browser);
//            $this->createPostByAdmin($browser);
//
//            $this->loginByAdmin($browser);
//            $this->createPostByCustomer($browser);
//            $this->loginByCustomer($browser);
//            $this->loginByRejectAccount($browser);
        });
    }

    public function listPost($browser) {
        $browser->visit('/post');
    }
    public function createPost($browser) {
        $browser->visit('/post/create')
            ->select('category_id', 1)
            ->typeSlowly('name', 'create post test')
            ->typeSlowly('price', 122)
            ->typeSlowly('content', 'mot ta create post test')
//            ->attach('files', '2cab38ad6d0cb052e91d.jpg')
//            ->typeSlowly('district_id', 1)
//            ->typeSlowly('ward_id', 1)
//            ->typeSlowly('address', 'ha loi')
            ->select('attr[state]', 1)
            ->select('attr[color]', 1)
            ->select('attr[guarantee]', 1)
            ->select('attr[made_in]', 1)->releaseMouse()->press('.btn-submit')->waitFor('.notify--success');
    }

    public function editPost($browser) {
        $browser->visit('post/edit/1699804525_21.htm')
            ->select('category_id', 1)
            ->typeSlowly('name', 'create post test')
            ->typeSlowly('price', 122)
            ->typeSlowly('content', 'mot ta create post test')
//            ->attach('files', '2cab38ad6d0cb052e91d.jpg')
//            ->typeSlowly('district_id', 1)
//            ->typeSlowly('ward_id', 1)
//            ->typeSlowly('address', 'ha loi')
            ->select('attr[state]', 1)
            ->select('attr[color]', 1)
            ->select('attr[guarantee]', 1)
            ->select('attr[made_in]', 1)->releaseMouse()->press('.btn-submit');
        return $browser;
    }

    public function validate($browser) {
        $browser->visit('/post/create')
            ->pause(2000)
            ->releaseMouse()->press('.btn-submit')
            ->waitFor('.error');
        return $browser;
    }

    public function approvePost($browser) {
        $browser->visit('/post')
            ->click('.btn-ajax.success')
        ->pause(2000)->waitFor('.success');
        return $browser;
    }

    public function rejectPost($browser) {
        $browser->visit('/post')
            ->click('.btn-ajax.warning')
            ->pause(2000)
            ->waitFor('.success');
        return $browser;
    }

    public function deletePost($browser) {
        $browser->visit('/post')
            ->click('.btn-ajax.danger')
            ->pause(1000);
        return $browser;
    }
}
