<?php

namespace Wallabag\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Wallabag\CoreBundle\Helper\ContentProxy;

class WebhookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('event', 'choice', array(
                'required' => true,
                'choices' => array(ContentProxy::EVENT_UPDATE => "New or updated entry")
                ))
            ->add('type', 'choice', array(
                'required' => true,
                'choices' => array('ifttt' => "Ifttt message", 'entry' => "wallabag webhook")
                ))
            ->add('url', 'text', array('required' => true))
            ->add('save', 'submit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wallabag\CoreBundle\Entity\Webhook',
        ));
    }

    public function getName()
    {
        return 'webhook_config';
    }
}
