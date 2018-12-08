<?php

namespace App\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use App\Entity\Property;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;


class ImageCacheSubscriber implements EventSubscriber
{

    private $cacheManager;

    private $helper;

    public function __construct(CacheManager $cacheManager, UploaderHelper $helper)
    {
        $this->cacheManager = $cacheManager;
        $this->helper = $helper;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate,
            Events::preRemove,
        ];
    }

    public function preUpdate(LifecycleEventArgs $args)
    {

        $entity = $args->getObject();
        if (!$entity instanceof Property)
        {
            return;
        }

        if ($entity->getImageFile() instanceof UploadedFile)
        {
            $this->cacheManager->remove($this->helper->asset($entity, 'imageFile'));
        }

    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Property) {
            return;
        }
        $this->cacheManager->remove($this->helper->asset($entity, 'imageFile'));
    }


}

