<?php

namespace Source\Controller;

use Source\Core\Controller;

/**
 * Class WebController
 * @package Source\App
 */
class WebController extends Controller
{
    /**
     * WebController constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/". CONF_VIEW_THEME ."/");
    }


    /**
     * @return void
     */
    public function home(): void
    {
        echo $this->view->render("home", [
            "title" => "Home"
        ]);
    }

    /**
     * Router error
     */
    public function error(): void
    {
        $this->message->info("O link que você acessou não existe")->flash();
        redirect("/");
    }
}