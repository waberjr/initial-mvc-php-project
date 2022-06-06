<?php

namespace Source\Core;

use Source\Support\Message;

/**
 * Class Model
 * @package Source\Models
 */
abstract class Model
{
    /** @var Message */
    protected Message $message;

    /**
     * Model constructor.
     * @param string $entity
     * @param array $required
     * @param string $primary
     * @param bool $timestamps
     */
    public function __construct()
    {
        $this->message = new Message();
    }

    /**
     * @return Message
     */
    public function message(): Message
    {
        return $this->message;
    }
}