<?php

namespace Modules\Block\Presenters;

use Laracasts\Presenter\Presenter;

class BlockPresenter extends Presenter
{
    /**
     * Get a bootstrap label of the block is online or offline
     * @return string
     */
    public function onlineLabel()
    {
        if ($this->entity->online) {
            return '<span class="badge bg-success p-1">Online</span>';
        }

        return '<span class="badge bg-danger p-1">Offline</span>';
    }
}
