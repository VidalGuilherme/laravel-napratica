<?php

namespace Tests\Feature;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupplierManagementTest extends TestCase
{
    public function test_new_supplier_model_validation()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post('/admin/suppliers', []);

        $response->assertSessionHasErrors(['supplier_type']);
    }

    public function test_supplier_model_update_feature()
    {
        $this->actingAs(User::factory()->create());

        $supplier = Supplier::factory()->create();

        $response = $this->put('/admin/suppliers/' . $supplier->id, [
            'personal_name' => 'Nome de Teste',
            'rg' => '12345678']);

        $this->assertDatabaseHas('suppliers', [
            'id' => $supplier->id,
            'personal_name' => 'Nome de Teste',
            'rg' => '12345678']
        );

        $response->assertStatus(302);
    }
}
