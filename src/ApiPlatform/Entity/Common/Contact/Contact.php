<?php declare(strict_types=1);

namespace App\ApiPlatform\Entity\Common\Contact;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * The website.
     *
     * @Groups({"venue:read", "venue:write"})
     * @Assert\Url()
     */
    public ?string $website;

    /**
     * The email address.
     *
     * @Groups({"venue:read", "venue:write"})
     * @Assert\Email()
     */
    public ?string $email;
}
