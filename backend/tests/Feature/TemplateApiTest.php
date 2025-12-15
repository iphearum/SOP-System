<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TemplateApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_template(): void
    {
        $payload = [
            'name' => 'Quality SOP',
            'version' => 'v1.0',
            'description' => 'Quality management',
            'sections_schema' => [['key' => 'scope', 'label' => 'Scope', 'required' => true]],
            'required_metadata' => ['department'],
            'status' => 'active',
        ];

        $response = $this->postJson('/api/v1/templates', $payload);

        $response->assertCreated();
        $this->assertDatabaseHas('templates', ['name' => 'Quality SOP']);
    }
}
