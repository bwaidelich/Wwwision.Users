<?php
namespace Wwwision\Users\Domain\Aggregate\User\Command;

final class MakeUserAdministrator
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