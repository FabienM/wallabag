<?php

namespace Wallabag\CoreBundle\Event\Subscriber;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Wallabag\CoreBundle\Event\Model\EntryEvent;
use Wallabag\CoreBundle\Helper\ContentProxy;
use Wallabag\CoreBundle\Webhook\WebhookManager;

class WebhookSubscriber implements EventSubscriberInterface
{
    /** @var WebhookManager */
    private $webhookManager;

    /**
     * WebhookSubscriber constructor.
     * @param WebhookManager $webhookManager
     */
    public function __construct(WebhookManager $webhookManager)
    {
        $this->webhookManager = $webhookManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            ContentProxy::EVENT_UPDATE => 'updatedEntry'
        );
    }

    public function updatedEntry(EntryEvent $event)
    {
        $this->webhookManager->handleEntry($event->getName(), $event->getEntry());
    }
}
