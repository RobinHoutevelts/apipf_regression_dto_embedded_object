<?php

namespace App\ApiPlatform\Entity\Venue;

use App\ApiPlatform\DataTransformer\DataTransferObjectInterface;
use App\ApiPlatform\Entity\Common\Contact\Contact;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class Venue implements DataTransferObjectInterface
{
    /**
     * The id of the venue
     *
     * @Groups({"venue:read"})
     * @var string
     */
    public string $id; // uuid

    /**
     * The title of the venue.
     *
     * @Groups({"venue:read", "venue:write"})
     * @Assert\NotBlank()
     * @var string
     */
    public string $title;

    /**
     * The alternative name of the venue.
     *
     * @Groups({"venue:read", "venue:write"})
     */
    public ?string $alternativeName;

    /**
     * The contact information of the venue.
     *
     * @Groups({"venue:read", "venue:write"})
     * @Assert\Valid()
     */
    public Contact $contact;
}
