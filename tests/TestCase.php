<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\TestDataGetters;
use Tests\Traits\TestRequestHelpers;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use TestDataGetters;
    use TestRequestHelpers;
}
