<?php

namespace Source\Support;

use Source\Core\Session;

/**
 * Class Message
 * @package Source\Support
 */
class Message
{
    /** @var */
    private $text;

    /** @var */
    private $type;

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function info(string $message): Message
    {
        $this->type = "blue darken-2";
        $this->text = $message;
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function success(string $message): Message
    {
        $this->type = "green darken-2";
        $this->text = $message;
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function warning(string $message): Message
    {
        $this->type = "yellow darken-3";
        $this->text = $message;
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function error(string $message): Message
    {
        $this->type = "red darken-2";
        $this->text = $message;
        return $this;
    }

    /**
     * Set flash Session Key
     */
    public function flash(): void
    {
        (new Session())->set("flash", $this);
    }

    /**
     * @return array
     */
    public function render(): array
    {
        return [
            "text" => $this->getText(),
            "classes" => $this->getType()
        ];
    }
}