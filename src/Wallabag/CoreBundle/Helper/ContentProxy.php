<?php

namespace Wallabag\CoreBundle\Helper;

use Graby\Graby;
use Psr\Log\LoggerInterface as Logger;
use Wallabag\CoreBundle\Entity\Entry;
use Wallabag\CoreBundle\Entity\Tag;
use Wallabag\CoreBundle\Tools\Utils;
use Wallabag\CoreBundle\Repository\TagRepository;

/**
 * This kind of proxy class take care of getting the content from an url
 * and update the entry with what it found.
 */
class ContentProxy
{
    protected $graby;
    protected $tagger;
    protected $logger;
    protected $tagRepository;

    public function __construct(Graby $graby, RuleBasedTagger $tagger, TagRepository $tagRepository, Logger $logger)
    {
        $this->graby = $graby;
        $this->tagger = $tagger;
        $this->logger = $logger;
        $this->tagRepository = $tagRepository;
    }

    /**
     * Fetch content using graby and hydrate given entry with results information.
     * In case we couldn't find content, we'll try to use Open Graph data.
     *
     * @param Entry  $entry Entry to update
     * @param string $url   Url to grab content for
     *
     * @return Entry
     */
    public function updateEntry(Entry $entry, $url)
    {
        $content = $this->graby->fetchContent($url);

        $title = $content['title'];
        if (!$title && isset($content['open_graph']['og_title'])) {
            $title = $content['open_graph']['og_title'];
        }

        $html = $content['html'];
        if (false === $html) {
            $html = '<p>Unable to retrieve readable content.</p>';

            if (isset($content['open_graph']['og_description'])) {
                $html .= '<p><i>But we found a short description: </i></p>';
                $html .= $content['open_graph']['og_description'];
            }
        }

        $entry->setUrl($content['url'] ?: $url);
        $entry->setTitle($title);
        $entry->setContent($html);
        $entry->setLanguage($content['language']);
        $entry->setMimetype($content['content_type']);
        $entry->setReadingTime(Utils::getReadingTime($html));
        $entry->setDomainName(parse_url($entry->getUrl(), PHP_URL_HOST));

        if (isset($content['open_graph']['og_image'])) {
            $entry->setPreviewPicture($content['open_graph']['og_image']);
        }

        try {
            $this->tagger->tag($entry);
        } catch (\Exception $e) {
            $this->logger->error('Error while trying to automatically tag an entry.', array(
                'entry_url' => $url,
                'error_msg' => $e->getMessage(),
            ));
        }

        return $entry;
    }

    /**
     * Assign some tags to an entry.
     *
     * @param Entry        $entry
     * @param array|string $tags  An array of tag or a string coma separated of tag
     */
    public function assignTagsToEntry(Entry $entry, $tags)
    {
        if (!is_array($tags)) {
            $tags = explode(',', $tags);
        }

        foreach ($tags as $label) {
            $label = trim($label);

            // avoid empty tag
            if (0 === strlen($label)) {
                continue;
            }

            $tagEntity = $this->tagRepository->findOneByLabel($label);

            if (is_null($tagEntity)) {
                $tagEntity = new Tag();
                $tagEntity->setLabel($label);
            }

            // only add the tag on the entry if the relation doesn't exist
            if (false === $entry->getTags()->contains($tagEntity)) {
                $entry->addTag($tagEntity);
            }
        }
    }
}
