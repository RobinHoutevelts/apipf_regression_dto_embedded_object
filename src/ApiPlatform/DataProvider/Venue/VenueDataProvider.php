<?php

namespace App\ApiPlatform\DataProvider\Venue;

use App\ApiPlatform\DataProvider\AbstractDataProvider;
use App\Entity\Venue;

class VenueDataProvider extends AbstractDataProvider
{
    protected function getResourceClass(): string
    {
        return Venue::class;
    }

    protected function usesUuid(): bool
    {
        return true;
    }
}
