<?php

namespace Kurious7\SimplePages\Tests;

use Kurious7\SimplePages\Models\SimplePage;

class SetOwnSlugTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('simple-pages.model', \Kurious7\SimplePages\Models\SimplePageNoAutoSlug::class);
    }

    /** @test */
    public function it_creates_page_with_own_slug()
    {
        $page = SimplePage::create([
            'title' => 'Hello, Test',
            'slug' => 'slug',
        ]);

        $this->assertInstanceOf(SimplePage::class, $page);
        $this->assertSame('Hello, Test', $page->title);
        $this->assertSame('slug', $page->slug);
    }
}
