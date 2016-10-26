<?php
namespace Wwwision\Users\Domain\Aggregate\User\Command;

use Neos\Cqrs\Command\CommandInterface;

final class MakeUserAdministrator implements CommandInterface
{
    /**
     * @var string
     */
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId() : string
    {
        return $this->userId;
    }

}