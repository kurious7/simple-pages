<?php

namespace Kurious7\SimplePages\Tests;

use Kurious7\SimplePages\SimplePagesServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'sqlite']);

        $this->setUpDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [
            SimplePagesServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');

        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('app.key', 'base64:6Cu/ozj4gPtIjmXjr8EdVnGFNsdRqZfHfVjQkmTlg4Y=');
    }

    protected function setUpDatabase()
    {
        include_once __DIR__.'/../database/migrations/create_simple_pages_table.php.stub';
        (new \CreateSimplePagesTable())->up();
    }
}
