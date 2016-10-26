<?php
namespace Wwwision\Users\Domain\Aggregate\User\Command;

use Neos\Cqrs\Command\CommandInterface;

final class RenameUser implements CommandInterface
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $newName;

    /**
     * @var int
     */
    private $expectedVersion;

    public function __construct(string $userId, string $newName, int $expectedVersion)
    {
        $this->userId = $userId;
        $this->newName = $newName;
        $this->expectedVersion = $expectedVersion;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getNewName(): string
    {
        return $this->newName;
    }

    public function getExpectedVersion(): int
    {
        return $this->expectedVersion;
    }

}