<?php

namespace Wallabag\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Webhook.
 *
 * @ORM\Table(name="`webhook`")
 * @ORM\Entity
 */
class Webhook
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="event", type="string")
     * @Assert\NotBlank()
     */
    public $event;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string")
     * @Assert\Url()
     * @Assert\NotBlank()
     */
    public $url;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     * @Assert\NotBlank()
     */
    public $type;

    /**
     * @var Config
     *
     * @ORM\ManyToOne(targetEntity="Wallabag\CoreBundle\Entity\Config", inversedBy="webhooks")
     */
    private $config;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }
}
