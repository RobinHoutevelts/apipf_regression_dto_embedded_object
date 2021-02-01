<?php

namespace App\ApiPlatform\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

abstract class AbstractDataPersister implements ContextAwareDataPersisterInterface
{
    protected ContextAwareDataPersisterInterface $dataPersister;

    public function __construct(ContextAwareDataPersisterInterface $dataPersister)
    {
        $this->dataPersister = $dataPersister;
    }

    public function supports($data, array $context = []): bool
    {
        $resourceClass = $this->getResourceClass();
        return $data instanceof $resourceClass;
    }

    public function persist($data, array $context = [])
    {
        // preSave
        $entity = $this->dataPersister->persist($data, $context);
        // postSave
        return $entity;
    }

    public function remove($data, array $context = [])
    {
        // preDelete
        $this->dataPersister->remove($data, $context);
        // postDelete
    }

    abstract protected function getResourceClass(): string;
}
