<?php

namespace App\ApiPlatform\DataTransformer\Venue;

use App\ApiPlatform\DataTransformer\AbstractDataTransformer;
use App\ApiPlatform\DataTransformer\DataTransferObjectInterface;
use App\ApiPlatform\Entity\Venue\Venue as VenueDto;
use App\Entity\Venue;

class VenueDataTransformer extends AbstractDataTransformer
{
    protected function getResourceClass(): string
    {
        return Venue::class;
    }

    protected function updateEntity(DataTransferObjectInterface $input, $entity = null, array $context = [])
    {
        if (!$entity instanceof Venue) {
            $entity = new Venue();
        }

        /** @var VenueDto $input */
        $entity->setTitle($input->title);

        return $entity;
    }

    protected function createOutputObject($entity, array $context): DataTransferObjectInterface
    {
        /** @var Venue $entity */
        $output = new VenueDto();

        $output->id = $entity->getUuid();
        $output->title = $entity->getTitle();

        return $output;
    }

}
