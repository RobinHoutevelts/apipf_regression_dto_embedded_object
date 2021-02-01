<?php

namespace App\ApiPlatform\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use ApiPlatform\Core\Validator\ValidatorInterface;

abstract class AbstractDataTransformer implements DataTransformerInterface
{
    protected ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function transform($input, string $to, array $context = [])
    {
        if (!empty($context['api_denormalize'])) {
            if (!$input instanceof DataTransferObjectInterface) {
                throw new \RuntimeException(
                    sprintf('Expected input "%s" to be of type "%s"', $input::class, DataTransformerInterface::class)
                );
            }

            // We received a POST/PUT, let's validate the input DTO
            // Make sure a 'groups' key exists, just to make life easier for extending classes.
            $context['groups'] ??= [];
            $this->validate($input);

            // And get the $entity that has to be updated
            $entity = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE] ?? null;

            // And actually do the update
            return $this->updateEntity($input, $entity, $context);
        }

        return $this->createOutputObject($input, $context);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        $resourceClass = $this->getResourceClass();

        if (!empty($context['api_denormalize'])) {
            // Convert sent input to a filled input DTO
            if ($data instanceof $resourceClass) {
                // already transformed
                return false;
            }

            $dtoClass = $context['input']['class'] ?? null;
            return $to === $resourceClass
                && is_subclass_of($dtoClass, DataTransferObjectInterface::class);
        }

        // Convert existing entity to an output DTO
        return $data instanceof $resourceClass
            && is_subclass_of($to, DataTransferObjectInterface::class);
    }

    /**
     * Validate the input object
     */
    protected function validate(DataTransferObjectInterface $input, array $context = []): void
    {
        $this->validator->validate($input, $context);
    }

    abstract protected function getResourceClass(): string;

    /**
     * Fill the $entity with values from $input.
     * If $entity is null it has to be created.
     *
     * @return object The created/updated $entity
     */
    abstract protected function updateEntity(DataTransferObjectInterface $input, $entity = null, array $context = []);

    /**
     * Create an output object based on the $entity
     */
    abstract protected function createOutputObject($entity, array $context): DataTransferObjectInterface;
}
