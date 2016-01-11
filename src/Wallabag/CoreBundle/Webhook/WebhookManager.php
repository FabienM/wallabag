<?php

namespace Wallabag\CoreBundle\Webhook;

use GuzzleHttp\Client;
use JMS\Serializer\Serializer;
use Wallabag\CoreBundle\Entity\Entry;
use Wallabag\CoreBundle\Webhook\Adapter\EntryWallabagAdapter;
use Wallabag\CoreBundle\Webhook\Adapter\EntryIftttAdapter;

class WebhookManager
{
    /** @var EntryAdapterInterface[] */
    private $entryAdapters;

    /** @var Client */
    private $guzzle;

    /** @var Serializer */
    private $serializer;

    /**
     * WebhookManager constructor.
     * @param Client $guzzle
     * @param Serializer $serializer
     */
    public function __construct(Client $guzzle, Serializer $serializer)
    {
        $this->guzzle = $guzzle;
        $this->serializer = $serializer;
        $this->entryAdapters = $this->getEntryAdapters();
    }

    protected function getEntryAdapters()
    {
        return array(
            'ifttt' => new EntryIftttAdapter(),
            'entry' => new EntryWallabagAdapter()
        );
    }

    public function handleEntry($eventId, Entry $entry)
    {
        $hooks = $entry->getUser()->getConfig()->getWebhooks();
        foreach ($hooks as $hook) {
            $adapter = $this->entryAdapters[$hook->getType()];
            if ($adapter === null || $hook->getEvent() !== $eventId) {
                continue;
            }
            $message = $adapter->adapt($entry);
            $this->guzzle->post($hook->getUrl(), array(
                'body' => $this->serializer->serialize($message),
                'http_errors' => false,
                'connect_timeout' => 1, // 1 second to connect
                'timeout' => .1 // We don't care from the answer
            ));
        }
    }
}
