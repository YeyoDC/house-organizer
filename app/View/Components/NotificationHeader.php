<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NotificationHeader extends Component
{
    public $title;
    public $subtitle;

    public function __construct($title = null, $subtitle = null)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
    }

    public function render()
    {
        return view('components.notification-header');
    }
}
