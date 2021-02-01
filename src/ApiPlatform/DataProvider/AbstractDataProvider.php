<?php

namespace App\ApiPlatform\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Security;

abstract class AbstractDataProvider implements CollectionDataProviderInterface, ItemDataProviderInterface, RestrictedDataProviderInterface
{
    protected CollectionDataProviderInterface $collectionDataProvider;
    protected ItemDataProviderInterface $itemDataProvider;
    protected Security $security;

    public function __construct(
        CollectionDataProviderInterface $collectionDataProvider,
        ItemDataProviderInterface $itemDataProvider,
        Security $security
    ) {
        $this->collectionDataProvider = $collectionDataProvider;
        $this->itemDataProvider = $itemDataProvider;
        $this->security = $security;
    }

    public function getCollection(string $resourceClass, string $operationName = null)
    {
        // Load all entities
        return $this->collectionDataProvider->getCollection($resourceClass, $operationName);
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        // Load a single instance of an entity

        if ($this->usesUuid() && is_string($id) && Uuid::isValid($id)) {
            $id = ['uuid' => $id];
        }
        return $this->itemDataProvider->getItem($resourceClass, $id, $operationName, $context);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        $class = $this->getResourceClass();
        return $resourceClass === $class;
    }

    protected function usesUuid(): bool
    {
        return false;
    }

    abstract protected function getResourceClass(): string;
}
