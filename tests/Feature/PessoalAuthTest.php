<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pessoal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PessoalAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_main_admin_can_create_pessoal_with_user()
    {
        // Cria admin principal (ID 1)
        $admin = User::factory()->create(['id' => 1]);

        $response = $this->actingAs($admin)->post(route('admin.pessoal.store'), [
            'nome' => 'Test Person',
            'cargo' => 'Developer',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.pessoal.index'));
        
        $this->assertDatabaseHas('pessoals', ['nome' => 'Test Person']);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        
        $pessoal = Pessoal::where('nome', 'Test Person')->first();
        $this->assertNotNull($pessoal->user_id);
        $this->assertEquals('test@example.com', $pessoal->user->email);
    }

    public function test_main_admin_can_update_pessoal_user_credentials()
    {
        $admin = User::factory()->create(['id' => 1]);
        
        // Cria usuário e pessoal vinculado
        $user = User::factory()->create(['email' => 'old@example.com']);
        $pessoal = Pessoal::create([
            'nome' => 'Test Person',
            'cargo' => 'Dev',
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($admin)->put(route('admin.pessoal.update', $pessoal), [
            'nome' => 'Test Person Updated',
            'cargo' => 'Dev',
            'email' => 'new@example.com',
            'password' => 'newpassword123',
        ]);

        $response->assertRedirect(route('admin.pessoal.index'));
        
        $this->assertDatabaseHas('users', ['email' => 'new@example.com']);
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }

    public function test_non_main_admin_cannot_create_user_via_pessoal()
    {
        // Cria admin secundário (ID 2)
        $admin = User::factory()->create(['id' => 2]);

        $response = $this->actingAs($admin)->post(route('admin.pessoal.store'), [
            'nome' => 'Test Person',
            'cargo' => 'Developer',
            'email' => 'hacker@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.pessoal.index'));
        
        $this->assertDatabaseHas('pessoals', ['nome' => 'Test Person']);
        // Usuário NÃO deve ser criado
        $this->assertDatabaseMissing('users', ['email' => 'hacker@example.com']);
        
        $pessoal = Pessoal::where('nome', 'Test Person')->first();
        $this->assertNull($pessoal->user_id);
    }
}
