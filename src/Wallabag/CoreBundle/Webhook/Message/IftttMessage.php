<?php

namespace Wallabag\CoreBundle\Webhook\Message;

class IftttMessage
{
    /** @var mixed */
    private $value1;

    /** @var mixed */
    private $value2;

    /** @var mixed */
    private $value3;

    /**
     * IftttMessage constructor.
     * @param mixed $value1
     * @param mixed $value2
     * @param mixed $value3
     */
    public function __construct($value1, $value2, $value3)
    {
        $this->value1 = $value1;
        $this->value2 = $value2;
        $this->value3 = $value3;
    }

    /**
     * @return mixed
     */
    public function getValue1()
    {
        return $this->value1;
    }

    /**
     * @param mixed $value1
     */
    public function setValue1($value1)
    {
        $this->value1 = $value1;
    }

    /**
     * @return mixed
     */
    public function getValue2()
    {
        return $this->value2;
    }

    /**
     * @param mixed $value2
     */
    public function setValue2($value2)
    {
        $this->value2 = $value2;
    }

    /**
     * @return mixed
     */
    public function getValue3()
    {
        return $this->value3;
    }

    /**
     * @param mixed $value3
     */
    public function setValue3($value3)
    {
        $this->value3 = $value3;
    }
}
