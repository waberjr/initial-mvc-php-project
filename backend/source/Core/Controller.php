<?php

namespace Source\Core;

use Source\Support\Message;

/**
 * Class Controller
 * @package Source\Core
 */
abstract class Controller
{
    /** @var View */
    protected View $view;

    /** @var Message */
    protected Message $message;

    /**
     * Controller constructor.
     * @param string|null $pathToViews
     */
    public function __construct(string $pathToViews = null)
    {
        $this->view = new View($pathToViews);
        $this->message = new Message();
    }
}