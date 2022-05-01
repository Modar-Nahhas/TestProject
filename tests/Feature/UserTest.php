<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $totalCount = 5;
        $response = $this->get("/api/v1/user/{$totalCount}/karma-position");
        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) use ($totalCount) {
            $json->hasAll('result', 'message', 'code', 'data')
                ->whereType('data', 'array');
            $json->count('data', $totalCount);
        });
    }
}
