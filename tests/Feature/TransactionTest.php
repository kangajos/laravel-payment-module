<?php

use Tests\TestCase;
use App\Models\Transaction;
use App\Models\User;
use Laravel\Passport\Passport;

class TransactionTest extends TestCase
{
    public function test_transaction_creation()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        dd($user);
        $response = $this->postJson('/api/process', ['amount' => 100]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('transactions', ['user_id' => $user->id, 'amount' => 100, 'status' => 'pending']);
    }

    public function test_user_transactions()
    {
        $user = User::factory()->create();
        Transaction::factory()->count(10)->create(['user_id' => $user->id]);
        Passport::actingAs($user);

        $response = $this->getJson('/api/transactions');

        $response->assertStatus(200)->assertJsonCount(10, 'data');
    }

    public function test_transaction_summary()
    {
        $user = User::factory()->create();
        Transaction::factory()->count(10)->create(['user_id' => $user->id]);
        Passport::actingAs($user);

        $response = $this->getJson('/api/summary');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'total_transactions',
            'average_amount',
            'highest_transaction',
            'lowest_transaction',
            'longest_name_transaction',
            'status_distribution',
        ]);
    }
}
