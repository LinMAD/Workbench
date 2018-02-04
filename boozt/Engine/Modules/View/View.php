<?php

namespace Engine\Modules\View;

class View
{
    /**
     * Pages title
     *
     * @var string
     */
    private $pageTitle;

    /**
     * Page's
     *
     * @var string
     */
    private $pageHeading;

    /**
     * Page's footer
     *
     * @var string
     */
    private $pageFooter;

    /**
     * Page's body
     *
     * @var
     */
    private $pageBody;

    /**
     * Formatted view
     *
     * @var string
     */
    private $view;

    /**
     * View constructor.
     *
     * @param AbstractViewBuilder $builder
     */
    public function __construct(AbstractViewBuilder $builder)
    {
        $this->pageTitle = $builder->pageTitle;
        $this->pageHeading = $builder->pageHeading;
        $this->pageBody = $builder->pageBody;
        $this->pageFooter = $builder->pageFooter;
    }

    /**
     * Formats and returns view
     */
    public function renderView(): string
    {
        $this->view  = '<html>';
        $this->view .= '<head>';
        $this->view .= '<title>'.$this->pageTitle.'</title>';
        $this->view .= $this->pageHeading;
        $this->view .= '</head>';
        $this->view .= '<body>';
        $this->view .= $this->pageBody;
        $this->view .= $this->pageFooter;
        $this->view .= '</body>';
        $this->view .= '</html>';

        return $this->view;
    }
}
