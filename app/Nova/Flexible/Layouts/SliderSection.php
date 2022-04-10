<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class SliderSection extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'slidersection';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Slider section';

    protected $limit = 2;

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('Title')
        ];
    }

}
