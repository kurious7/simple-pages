<?php
namespace Kurious7\SimplePages\Tests;

use Kurious7\SimplePages\Models\SimplePage;

class CreatePageTest extends TestCase
{
    /** @test */
    public function it_creates_pages_in_the_database()
    {
        $page = SimplePage::create(['title' => 'Hello, Test']);

        $this->assertInstanceOf(SimplePage::class, $page);
        $this->assertSame('Hello, Test', $page->title);
    }
}
