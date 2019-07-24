<?php

namespace Kurious7\SimplePages\Tests;

use Carbon\Carbon;
use Kurious7\SimplePages\Models\SimplePage;

class GetPagesTest extends TestCase
{
    /** @test */
    public function it_fetches_only_visible_in_menu_pages()
    {
        $visiblePage = SimplePage::create(['title' => 'Hello, Visible page', 'show_in_menu' => true]);
        $unvisiblePage = SimplePage::create(['title' => 'Hello, Unvisible page', 'show_in_menu' => false]);

        $visiblePages = SimplePage::visibleInMenu()->get();
        $titles = $visiblePages->pluck('title');

        $this->assertContains('Hello, Visible page', $titles);
        $this->assertNotContains('Hello, Unvisible page', $titles);
    }

    /** @test */
    public function it_fetches_published_pages()
    {
        $nonPublicPage = SimplePage::create([
            'title' => 'Hello, Non public page',
            'public' => false,
        ]);
        $nonPublicWithDatePage = SimplePage::create([
            'title' => 'Hello, Non public page',
            'public' => false,
            'public_from' => (new Carbon)->subDays(5),
            'public_until' => (new Carbon)->addDays(5),
        ]);
        $alwaysPublicPage = SimplePage::create([
            'title' => 'Hello, Hard public page',
            'public' => true,
        ]);
        $fromDatePublicPage = SimplePage::create([
            'title' => 'Hello, Public from date page',
            'public' => true,
            'public_from' => (new Carbon)->subDays(5),
        ]);
        $untilDatePublicPage = SimplePage::create([
            'title' => 'Hello, Public until date page',
            'public' => true,
            'public_until' => (new Carbon)->addDays(5),
        ]);
        $betweenFromAndUntilDatePublicPage = SimplePage::create([
            'title' => 'Hello, Public from date until date page',
            'public' => true,
            'public_from' => (new Carbon)->subDays(5),
            'public_until' => (new Carbon)->addDays(5),
        ]);
        $pastDateNonPublicPage = SimplePage::create([
            'title' => 'Hello, Non public past page',
            'public' => true,
            'public_from' => (new Carbon)->subDays(15),
            'public_until' => (new Carbon)->subDays(5),
        ]);
        $futureDateNonPublicPage = SimplePage::create([
            'title' => 'Hello, Non public future page',
            'public' => true,
            'public_from' => (new Carbon)->addDays(5),
            'public_until' => (new Carbon)->addDays(15),
        ]);

        $publicPages = SimplePage::published()->get();
        $titles = $publicPages->pluck('title');

        $this->assertContains($alwaysPublicPage->title, $titles);
        $this->assertContains($fromDatePublicPage->title, $titles);
        $this->assertContains($untilDatePublicPage->title, $titles);
        $this->assertContains($betweenFromAndUntilDatePublicPage->title, $titles);
        $this->assertNotContains($nonPublicPage->title, $titles);
        $this->assertNotContains($nonPublicWithDatePage->title, $titles);
        $this->assertNotContains($pastDateNonPublicPage->title, $titles);
        $this->assertNotContains($futureDateNonPublicPage->title, $titles);
    }
}
