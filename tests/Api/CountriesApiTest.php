<?php

namespace Tests\Api;

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountriesApiTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $country1 = Country::factory()->create();
        $country2 = Country::factory()->create();

        $this->assertEquals(
            [
                $country1->toArray(),
                $country2->toArray(),
            ],
            $this->get(route('countries.index'))->json()
        );
    }
}
