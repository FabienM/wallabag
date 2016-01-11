<?php

namespace Wallabag\CoreBundle\Webhook\Message;

class WallabagWebhookMessage
{
    /** @var string */
    private $url;

    /** @var string */
    private $tags;

    /**
     * WallabagWebhookMessage constructor.
     * @param string $url
     * @param string $tags
     */
    public function __construct($url, $tags)
    {
        $this->url = $url;
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param string $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }
}
