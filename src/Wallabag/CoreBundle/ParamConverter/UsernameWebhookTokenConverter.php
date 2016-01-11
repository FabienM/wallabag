<?php

namespace Wallabag\CoreBundle\ParamConverter;

use Wallabag\UserBundle\Repository\UserRepository;

class UsernameWebhookTokenConverter extends UsernameTokenConverter
{
    protected function findUser(UserRepository $userRepository, $username, $token)
    {
        return $userRepository->findOneByUsernameAndWebhooktoken($username, $token);
    }
}
