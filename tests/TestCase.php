<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Setup the application.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }
}
