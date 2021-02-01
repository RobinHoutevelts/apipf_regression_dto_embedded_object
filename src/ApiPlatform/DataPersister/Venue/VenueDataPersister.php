<?php

namespace App\ApiPlatform\DataPersister\Venue;

use App\ApiPlatform\DataPersister\AbstractDataPersister;
use App\Entity\Venue;

class VenueDataPersister extends AbstractDataPersister
{
    protected function getResourceClass(): string
    {
        return Venue::class;
    }
}
