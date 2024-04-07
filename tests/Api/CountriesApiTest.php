<?php

namespace Tests\Api;

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CountriesApiTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $countrySE = Country::factory()->create(['code' => 'SE']);
        $countryFI = Country::factory()->create(['code' => 'FI']);

        $this->assertEquals(
            [
                $countryFI->toArray(),
                $countrySE->toArray(),
            ],
            $this->get(route('countries.index'))->json()
        );
    }

    public function testShow(): void
    {
        $country = Country::factory()->create();

        $this->get(route('countries.show', $country))
            ->assertExactJson($country->toArray())
            ->assertStatus(200);
    }

    public function testStore(): void
    {
        $this->post(route('countries.store'), ['code' => 'FI'])
            ->assertExactJson([
                'code' => 'FI',
                'name' => 'Finland',
            ])
            ->assertStatus(201);

        // Invalid input
        $output = $this->post(route('countries.store'), ['code' => 'Se']);
        try {
            $errorsWereAsserted = false;
            // Touching the output causes the error to be thrown :shrug:
            $output->assertJson([]);
        } catch (ValidationException $e) {
            $this->assertEquals(
                [
                    'code' => ['The code field format is invalid.'],
                ],
                $e->validator->errors()->toArray()
            );
            $errorsWereAsserted = true;
        }
        $output->assertStatus(302);
        $this->assertTrue($errorsWereAsserted);
    }

    public function testUpdate(): void
    {
        $country = Country::factory()->create(['code' => 'SV']);

        $this->put(route('countries.update', $country), ['code' => 'FI'])
            ->assertExactJson([
                'code' => 'FI',
                'name' => 'Finland',
            ])
            ->assertStatus(200);

        // Invalid input
        $output = $this->put(route('countries.update', $country), ['code' => 'Se']);
        try {
            $errorsWereAsserted = false;
            // Touching the output causes the error to be thrown :shrug:
            $output->assertJson([]);
        } catch (ValidationException $e) {
            $this->assertEquals(
                [
                    'code' => ['The code field format is invalid.'],
                ],
                $e->validator->errors()->toArray()
            );
            $errorsWereAsserted = true;
        }
        $output->assertStatus(302);
        $this->assertTrue($errorsWereAsserted);
    }

    public function testDestroy(): void
    {
        $country = Country::factory()->create();

        $this->delete(route('countries.destroy', $country))
            ->assertStatus(204);

        $this->assertDatabaseMissing('countries', [
            'id' => $country->id,
        ]);
    }
}
