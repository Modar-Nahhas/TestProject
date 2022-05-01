<?php

namespace Tests\Feature;

use App\Models\User;
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
        $userId = 5;
        $totalCount = 30;
        $response = $this->get("/api/v1/user/{$userId}/karma-position?num_users={$totalCount}", [
            'accept' => 'application/json'
        ]);
        $response->assertStatus(200);

        //Test response structure and data count
        $response->assertJson(function (AssertableJson $json) use ($totalCount) {
            $json->hasAll('result', 'message', 'code', 'data')
                ->whereType('data', 'array');
            $json->count('data', $totalCount);
        });

        //Test positions' calculations
        $users = json_decode($response->getContent())->data;
        foreach ($users as $user) {
            $dbPosition = User::getPosition($user->karma_score, '<=');
            $this->assertEquals($dbPosition, $user->position);
        }
    }
}
