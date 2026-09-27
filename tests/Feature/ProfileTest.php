<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this
            ->actingAs($user)
            ->get('/app/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this
            ->actingAs($user)
            ->post('/app/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'monthly_income' => 5000000,
                'payday_date' => 25,
                'payday_frequency' => 'monthly',
                'financial_goal_type' => 'balanced',
                'dependents_count' => 0,
                'risk_profile' => 'moderate',
                'recommendation_frequency' => 'month_start',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
    }
}
