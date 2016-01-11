<?php

namespace Wallabag\CoreBundle\Webhook\Adapter;

use Wallabag\CoreBundle\Entity\Entry;
use Wallabag\CoreBundle\Webhook\EntryAdapterInterface;
use Wallabag\CoreBundle\Webhook\Message\WallabagWebhookMessage;

class EntryWallabagAdapter implements EntryAdapterInterface
{
    public function adapt(Entry $entry)
    {
        return new WallabagWebhookMessage($entry->getUrl(), implode(',', $entry->getTags()));
    }

}
