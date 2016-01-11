<?php

namespace Wallabag\CoreBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Wallabag\CoreBundle\Entity\Entry;
use Wallabag\CoreBundle\Entity\Tag;
use Wallabag\UserBundle\Entity\User;

class WebhookController extends Controller
{
    /**
     * @ApiDoc(
     *       parameters={
     *          {"name"="url", "dataType"="string", "required"=true, "format"="http://www.test.com/article.html", "description"="Url for the entry."},
     *          {"name"="title", "dataType"="string", "required"=false, "description"="Optional, we'll get the title from the page."},
     *          {"name"="tags", "dataType"="string", "required"=false, "format"="tag1,tag2,tag3", "description"="a comma-separated list of tags."},
     *       }
     * )
     *
     * @Route("/webhook/{username}/{token}", methods={"POST"}, name="webhook_post")
     * @ParamConverter("user", class="WallabagUserBundle:User", converter="username_webhooktoken_converter")
     *
     * @param User $user
     */
    public function webhookPostAction(User $user, Request $request)
    {
        $url = $request->request->get('url');

        $entry = $this->get('wallabag_core.content_proxy')->updateEntry(
            new Entry($user),
            $url
        );

        $tags = $request->request->get('tags', '');
        if (!empty($tags)) {
            $this->assignTagsToEntry($entry, $tags);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($entry);
        $em->flush();

        $json = $this->get('serializer')->serialize($entry, 'json');

        return new Response($json, 200, array('application/json'));
    }

    /**
     * @param Entry  $entry
     * @param string $tags
     */
    private function assignTagsToEntry(Entry $entry, $tags)
    {
        foreach (explode(',', $tags) as $label) {
            $label = trim($label);
            $tagEntity = $this
                ->getDoctrine()
                ->getRepository('WallabagCoreBundle:Tag')
                ->findOneByLabel($label);

            if (is_null($tagEntity)) {
                $tagEntity = new Tag();
                $tagEntity->setLabel($label);
            }

            // only add the tag on the entry if the relation doesn't exist
            if (!$entry->getTags()->contains($tagEntity)) {
                $entry->addTag($tagEntity);
            }
        }
    }
}
