<?php

namespace Engine\Modules\View;

abstract class AbstractViewBuilder
{
    /**
     * Pages title
     *
     * @var string
     */
    public $pageTitle;

    /**
     * Page's
     *
     * @var string
     */
    public $pageHeading;

    /**
     * Page's footer
     *
     * @var string
     */
    public $pageFooter;

    /**
     * Page's body
     *
     * @var
     */
    public $pageBody;

    /**
     * Formatted view
     *
     * @var string
     */
    public $view;

    /**
     * @param string $title
     *
     * @return $this
     */
    public function addTitle(string $title)
    {
        $this->pageTitle = $title;

        return $this;
    }

    /**
     * @param string $heading
     * @return $this
     */
    public function addHeading(string $heading)
    {
        $this->pageHeading = $heading;

        return $this;
    }

    /**
     * @param string $footer
     * @return $this
     */
    public function addFooter(string $footer)
    {
        $this->pageFooter = $footer;

        return $this;
    }

    /**
     * @param string $body
     * @return $this
     */
    public function addBody(string $body)
    {
        $this->pageBody = $body;

        return $this;
    }

    /**
     * Must build page in immutable way
     * @return mixed
     */
    abstract public function buildPage();
}
