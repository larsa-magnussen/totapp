<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\TestDataGetters;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use TestDataGetters;
}
