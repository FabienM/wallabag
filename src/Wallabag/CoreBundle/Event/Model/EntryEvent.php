<?php

namespace Wallabag\CoreBundle\Event\Model;

use Symfony\Component\EventDispatcher\Event;
use Wallabag\CoreBundle\Entity\Entry;

class EntryEvent extends Event
{
    /** @var Entry */
    private $entry;

    /**
     * EntryAddedEvent constructor.
     * @param Entry $entry
     */
    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
    }

    /**
     * @return Entry
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * @param Entry $entry
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;
    }
}
