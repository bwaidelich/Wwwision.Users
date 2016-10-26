<?php
namespace Wwwision\Users\Domain\Aggregate\User\Event;

use Neos\Cqrs\Event\EventInterface;

final class UserWasRenamed implements EventInterface
{

    /**
     * @var string
     */
    private $userIdentifier;

    /**
     * @var string
     */
    private $oldName;

    /**
     * @var string
     */
    private $newName;

    public function __construct(string $userIdentifier, string $newName, string $oldName = '- unknown -')
    {
        $this->userIdentifier = $userIdentifier;
        $this->newName = $newName;
        $this->oldName = $oldName;
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    public function getNewName(): string
    {
        return $this->newName;
    }

    public function getOldName(): string
    {
        return $this->oldName;
    }

}