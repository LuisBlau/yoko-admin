<?php


namespace App\Entity;


class NetsapiensMessages
{
    /**
     * @var
     */
    private $numberFrom;
    /**
     * @var
     */
    private $numberTo;
    /**
     * @var
     */
    private $message;
    /**
     * @var
     */
    private $type;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getNumberTo()
    {
        return $this->numberTo;
    }

    /**
     * @param mixed $numberTo
     */
    public function setNumberTo($numberTo): void
    {
        $this->numberTo = $numberTo;
    }

    /**
     * @return mixed
     */
    public function getNumberFrom()
    {
        return $this->numberFrom;
    }

    /**
     * @param mixed $numberFrom
     */
    public function setNumberFrom($numberFrom): void
    {
        $this->numberFrom = $numberFrom;
    }


}