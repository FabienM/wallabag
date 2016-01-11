<?php

namespace Wallabag\CoreBundle\Webhook;

use Wallabag\CoreBundle\Entity\Entry;

interface EntryAdapterInterface
{
    /**
     * Adapt an entry to a serializable object
     * @param Entry $entry
     * @return object
     */
    public function adapt(Entry $entry);
}
