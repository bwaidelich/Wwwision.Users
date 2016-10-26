<?php
namespace Wwwision\Users\Domain\Aggregate\User\Event;

use Neos\Cqrs\Event\EventInterface;

final class UserWasMadeAdministrator implements EventInterface
{
    /**
     * @var string
     */
    private $userIdentifier;

    public function __construct(string $userIdentifier)
    {
        $this->userIdentifier = $userIdentifier;
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

}