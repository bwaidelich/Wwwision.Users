<?php
namespace Wwwision\Users\Domain\Aggregate\User\Event;

use Neos\Cqrs\Event\EventInterface;

final class UserHasSignedUp implements EventInterface
{
    /**
     * @var string
     */
    private $userIdentifier;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $hashedPassword;

    public function __construct(string $userIdentifier, string $name, string $username, string $hashedPassword)
    {
        $this->userIdentifier = $userIdentifier;
        $this->name = $name;
        $this->username = $username;
        $this->hashedPassword = $hashedPassword;
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }
}