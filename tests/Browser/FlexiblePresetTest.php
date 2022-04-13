<?php

use Laravel\Dusk\Browser;

beforeEach(function () {
    $this->artisan('migrate:fresh', ['--seed' => true]);
});

test('a flexible field can be configured properly with a preset class', function() {
    $this->browse(function (Browser $browser) {
        login($browser);

        $browser->visit('/nova/resources/content-pages/new')
                ->waitFor('@content')
                ->assertPresent('@content')
                ->assertPresent('@toggle-layouts-dropdown-or-add-default')
                ->assertSeeIn('@toggle-layouts-dropdown-or-add-default', 'Add page block')

                ->press('@toggle-layouts-dropdown-or-add-default')
                ->click('@add-slidersection')
                ->waitFor('@content-0')
                ->assertSeeIn('@content-0', 'Slider section')
                ->assertPresent('[dusk="content-0"] input[type="text"][placeholder="Title"]')

                ->press('@toggle-layouts-dropdown-or-add-default')
                ->click('@add-text')
                ->waitFor('@content-1')
                ->assertSeeIn('@content-1', 'Simple text block')
                ->assertPresent('[dusk="content-1"] label[for="content-default-markdown-field"]');
    });
});
