<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;

class Datetime extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Carbon $date, public string $format = 'long')
    {
        // For now, just support Europe/Berlin.
        $this->date->setTimezone('Europe/Berlin');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): string
    {
        return $this->date->isoFormat($this->format());
    }

    /**
     * Define a default format.
     */
    protected function format(): string
    {
        return match ($this->format) {
            'short' => 'Do MMMM YYYY',
            default => 'Do MMMM YYYY, HH:mm',
        };
    }
}
