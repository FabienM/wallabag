<?php

namespace Wallabag\CoreBundle\ParamConverter;

use Wallabag\UserBundle\Repository\UserRepository;

class UsernameRssTokenConverter extends UsernameTokenConverter
{
    protected function findUser(UserRepository $userRepository, $username, $token)
    {
        return $userRepository->findOneByUsernameAndRsstoken($username, $token);
    }
}
