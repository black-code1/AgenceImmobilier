<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Notifications\ContactRequestNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PropertyTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_send_not_found_on_non_existent_property(): void
    {
        $response = $this->get('/biens/nulla-qui-ea-autem-amet-et-culpa-est-1');

        $response->assertStatus(404);
    }

    public function test_redirect_on_bad_slug_property(): void
    {
        /** @var Property $property */
        $property = Property::factory()->create();
        $response = $this->get('/biens/vitae-eligendi-labore-harum-laboriosam-est-' . $property->id);
        $response->assertRedirectToRoute('property.show', ['property' => $property->id, 'slug' => $property->getSlug()]);
    }

    public function test_ok_on_property(): void
    {
        /** @var Property $property */
        $property = Property::factory()->create();
        $response = $this->get("/biens/{$property->getSlug()}-{$property->id}");
        $response->assertOk();
        $response->assertSee($property->title);
    }

    public function test_error_on_contact(): void
    {
        /** @var Property $property */
        $property = Property::factory()->create();
        $response = $this->post("/biens/{$property->id}/contact", [
            "firstname" => "John",
            "lastname" => "Doe",
            "phone" => "0000000000",
            "email" => "doe",
            "message" => "Pouveez vous me recontacter"
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHasInput('email', 'doe');
    }

    public function test_ok_on_contact(): void
    {
        Notification::fake();
        /** @var Property $property */
        $property = Property::factory()->create();
        $response = $this->post("/biens/{$property->id}/contact", [
            "firstname" => "John",
            "lastname" => "Doe",
            "phone" => "0000000000",
            "email" => "doe@demo.fr",
            "message" => "Pouveez vous me recontacter"
        ]);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');
//        Notification::assertCount(1);
        Notification::assertSentOnDemand(ContactRequestNotification::class);
    }
}
