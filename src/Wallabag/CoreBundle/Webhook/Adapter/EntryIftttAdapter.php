<?php

namespace Wallabag\CoreBundle\Webhook\Adapter;

use Wallabag\CoreBundle\Entity\Entry;
use Wallabag\CoreBundle\Webhook\EntryAdapterInterface;
use Wallabag\CoreBundle\Webhook\Message\IftttMessage;

class EntryIftttAdapter implements EntryAdapterInterface
{
    public function adapt(Entry $entry)
    {
        return new IftttMessage($entry->getUrl(), implode(',', $entry->getTags()), $entry->getPreviewPicture());
    }
}
