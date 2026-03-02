<?php

use App\Models\ContactInquiry;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create();
    $this->actingAs($this->admin);
});

test('admin can view inquiries index', function () {
    ContactInquiry::factory()->count(3)->create();

    $this->get(route('admin.inquiries.index'))
        ->assertOk();
});

test('admin can view a single inquiry', function () {
    $inquiry = ContactInquiry::factory()->create([
        'name' => 'Test Inquirer',
    ]);

    $this->get(route('admin.inquiries.show', $inquiry))
        ->assertOk()
        ->assertSee('Test Inquirer');
});

test('admin can delete an inquiry', function () {
    $inquiry = ContactInquiry::factory()->create();

    $this->delete(route('admin.inquiries.destroy', $inquiry))
        ->assertRedirect(route('admin.inquiries.index'));

    $this->assertDatabaseMissing('contact_inquiries', ['id' => $inquiry->id]);
});

test('admin can mark inquiry as read', function () {
    $inquiry = ContactInquiry::factory()->create(['status' => 'new']);

    $this->patch(route('admin.inquiries.status', $inquiry), [
        'status' => 'read',
    ])->assertRedirect();

    $this->assertDatabaseHas('contact_inquiries', [
        'id' => $inquiry->id,
        'status' => 'read',
    ]);
});
