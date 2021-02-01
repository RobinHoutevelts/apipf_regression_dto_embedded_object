### Info

- ApiResource
   - [src/Entity/Venue.php](src/Entity/Venue.php)
- InputDTO
   - [src/ApiPlatform/Entity/Venue/Venue.php](src/ApiPlatform/Entity/Venue/Venue.php)
- Object on InputDTO that isn't being documented
   - [src/ApiPlatform/Entity/Common/Contact/Contact.php](src/ApiPlatform/Entity/Common/Contact/Contact.php)

In `>=2.6.0` object properties of my InputDTO aren't recognized.

In `2.5.10` this DTO resulted in the following documentation output:

```php
<?php
class Venue
{
    ...

    /**
     * The contact information of the venue.
     *
     * @Groups({"venue:read", "venue:write"})
     * @Assert\Valid()
     */
    public Contact $contact;
}

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
```

![s](https://i.kzen.pro/2021-02-01/19-42-17--cKO7D.png)


But since `>=2.6.0` I get:

![s](https://i.kzen.pro/2021-02-01/19-25-19--aqZKP.png)

## Setup

Add a `.env`

```dotenv
###> symfony/framework-bundle ###
APP_ENV=local
APP_SECRET=3baaaaaaaaaaaaaaaaaaaa360ae76fa3
###< symfony/framework-bundle ###

###> nelmio/cors-bundle ###
CORS_ALLOW_ORIGIN=^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$
###< nelmio/cors-bundle ###

DB_HOST=127.0.0.1
DB_USERNAME=database
DB_PASSWORD=database
DB_DATABASE=database
DB_PORT=
```

Then run composer, setup database and visit api docs

```
composer install
bin/console doctrine:schema:update --force
php -S localhost:8000 -t public/ 
```

And visit it http://localhost:8000/api

Switch to the first commit `23a9cecdb77b1cda366aee50ca4e4650d3912bba` which has Api-Platform `2.6.1` and is broken. 
