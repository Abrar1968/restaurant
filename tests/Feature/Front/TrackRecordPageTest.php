<?php

use App\Models\TrackRecord;

test('track record page loads successfully', function () {
    $this->get(route('track-record'))->assertOk();
});

test('track record page displays milestones', function () {
    $record = TrackRecord::factory()->create([
        'year' => 2024,
        'title' => 'Major Milestone Test',
        'description' => 'A big achievement for testing purposes.',
    ]);

    $this->get(route('track-record'))
        ->assertOk()
        ->assertSee('Major Milestone Test')
        ->assertSee('2024');
});
