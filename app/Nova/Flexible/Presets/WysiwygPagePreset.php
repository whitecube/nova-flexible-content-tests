<?php

namespace App\Nova\Flexible\Presets;

use App\Nova\Flexible\Layouts\SliderSection;
use Laravel\Nova\Fields\Markdown;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Preset;

class WysiwygPagePreset extends Preset
{
    /**
     * Execute the preset configuration
     *
     * @return void
     */
    public function handle(Flexible $field)
    {
        $field->button('Add page block')
            ->addLayout(SliderSection::class)
            ->addLayout('Simple text block', 'text', [
                Markdown::make('Content')
            ]);
    }

}
