<?php

use App\Models\Post;
use Laravel\Dusk\Browser;

beforeEach(function () {
    $this->artisan('migrate:fresh', ['--seed' => true]);
});

test('an empty flexible field renders correctly', function() {
    $this->browse(function (Browser $browser) {
        login($browser);

        $browser->visit('/nova/resources/posts/new')
                ->waitFor('@content')
                ->assertPresent('@content')
                ->assertNotPresent('@content-0')
                ->assertPresent('@toggle-layouts-dropdown-or-add-default');
    });
});

test('a flexible field with existing layout instances renders correctly', function() {
    $this->browse(function (Browser $browser) {
        login($browser);

        $browser->visit('/nova/resources/posts/1/edit')
                ->waitFor('@content')
                ->assertPresent('@content')
                ->assertPresent('@content-0')
                ->assertPresent('@content-1')
                ->assertInputValue('@first_layout__title', 'Hello there')
                ->assertPresent('@toggle-layouts-dropdown-or-add-default');
    });
});

test('editing a field in a flexible layout saves the data correctly', function() {
    $this->browse(function (Browser $browser) {
        login($browser);

        $browser->visit('/nova/resources/posts/1/edit')
            ->waitFor('@content')
            ->assertInputValue('[dusk="content-0"] #title-default-text-field', 'Hello there')
            ->type('[dusk="content-0"] #title-default-text-field', 'Foobar')
            ->press('@update-button')
            ->waitFor('@posts-detail-component')
            ->assertSeeIn('@detail-content-0', 'Foobar');

        $post = Post::first();

        $this->assertSame($post->content->first()->title, 'Foobar');
    });
});

test('a flexible layout instance can be deleted', function() {
    $this->browse(function (Browser $browser) {
        login($browser);

        $browser->visit('/nova/resources/posts/1/edit')
            ->waitFor('@content')
            ->press('[dusk="content-1"] [dusk="delete-group"]')
            ->waitFor('@confirm-delete-button')
            ->press('@confirm-delete-button')
            ->waitUntilMissing('@content-1')
            ->press('@update-button')
            ->waitFor('@detail-content-0')
            ->assertDontSee('@detail-content-1');

        $post = Post::first();

        $this->assertCount(1, $post->content);
    });
});

test('a flexible content can specify a maximum amount of layout instances', function() {
    $this->browse(function (Browser $browser) {
        login($browser);

        $browser->visit('/nova/resources/posts/1/edit')
            ->waitFor('@content')
            ->press('@toggle-layouts-dropdown-or-add-default')
            ->click('@add-slidersection')
            ->waitFor('@content-2')
            ->assertNotPresent('@toggle-layouts-dropdown-or-add-default')
            ->press('[dusk="content-2"] [dusk="delete-group"]')
            ->waitFor('@confirm-delete-button')
            ->press('@confirm-delete-button')
            ->waitUntilMissing('@content-2')
            ->assertPresent('@toggle-layouts-dropdown-or-add-default');
    });
});

test('a flexible content can specify a maximum amount of a layout type', function() {
    $this->browse(function (Browser $browser) {
        login($browser);

        $browser->visit('/nova/resources/posts/new')
            ->waitFor('@content')
            ->press('@toggle-layouts-dropdown-or-add-default')
            ->click('@add-slidersection')
            ->waitFor('@content-0')
            ->press('@toggle-layouts-dropdown-or-add-default')
            ->click('@add-slidersection')
            ->waitFor('@content-1')
            ->press('@toggle-layouts-dropdown-or-add-default')
            ->assertPresent('@add-wysiwyg')
            ->assertPresent('@add-video')
            ->assertNotPresent('@add-slidersection');
    });
});

test('a flexible field can be dependent on another field', function() {
    $this->browse(function (Browser $browser) {
        login($browser);

        $browser->visit('/nova/resources/posts/new')
            ->waitFor('@content')
            ->assertNotPresent('@credits')
            ->click('[name="Show credits"]')
            ->waitFor('@credits')
            ->click('[name="Show credits"]')
            ->waitUntilMissing('@credits');
    });
});
