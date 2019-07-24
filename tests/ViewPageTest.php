<?php

namespace Kurious7\SimplePages\Tests;

use Kurious7\SimplePages\Models\SimplePage;

class ViewPageTest extends TestCase
{
    /** @test */
    public function public_page_can_be_accessed()
    {
        $page = SimplePage::create([
            'title' => 'Dial Home',
            'public' => true,
        ]);

        $this->get('/p/dial-home')
            ->assertViewIs('simple-pages::index')
            ->assertViewHas('page', $page)
            ->assertStatus(200);
    }

    /** @test */
    public function non_public_page_gives_a_404()
    {
        $page = SimplePage::create([
            'title' => 'Dial Home',
            'public' => false,
        ]);

        $this->get('/p/dial-home')
            ->assertStatus(404);
    }
}
