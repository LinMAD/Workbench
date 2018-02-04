<?php

namespace App\View;

use Engine\Modules\View\AbstractViewBuilder;
use Engine\Modules\View\View;

class ViewBuilder extends AbstractViewBuilder
{
    /**
     * Add some styles to body
     *
     * @param string $body
     *
     * @return $this
     */
    public function addBody(string $body)
    {
        // TODO use bootstrap css classes
        $this->pageBody = '<pre>' . $body . '</pre>';

        return $this;
    }

    /**
     * Must build page in immutable way
     * @return mixed
     */
    public function buildPage()
    {
        return (new View($this))->renderView();
    }
}