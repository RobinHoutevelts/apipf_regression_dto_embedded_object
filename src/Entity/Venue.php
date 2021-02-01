<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VenueRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use App\ApiPlatform\Entity\Venue\Venue as VenueDto;

/**
 * @ApiResource(
 *     output=VenueDto::CLASS,
 *     input=VenueDto::CLASS,
 *     normalizationContext={"groups"={"venue:read"}},
 *     denormalizationContext={"groups"={"venue:write"}},
 *     collectionOperations={
 *         "get"={
 *              "normalization_context"={"groups"={"venue:collection:read"}}
 *         },
 *         "post"={
 *              "denormalization_context"={"groups"={"venue:write"}}
 *         }
 *     },
 *     itemOperations={"get", "put", "delete"}
 * )
 * @ORM\Entity(repositoryClass=VenueRepository::class)
 */
class Venue
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @ApiProperty(identifier=false)
     */
    private $id;

    /**
     * @ORM\Column(type="uuid", unique=true)
     * @ApiProperty(identifier=true)
     * @SerializedName("id")
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    public function __construct(UuidInterface $uuid = null)
    {
        $this->uuid = $uuid ?: Uuid::uuid4();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }
}
