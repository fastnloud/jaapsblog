<?php

namespace Reply\Service;

use Application\Entity\AbstractEntityService;

class Reply extends AbstractEntityService
{

    public function getReplies()
    {
        return $this->getEntityManager()
                    ->getRepository('Reply\Entity\Reply')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->getReplies();
    }

    public function getReply($id)
    {
        return $this->getEntityManager()
                    ->getRepository('Reply\Entity\Reply')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->getReply($id);
    }

}