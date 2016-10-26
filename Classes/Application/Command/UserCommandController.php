<?php
namespace Wwwision\Users\Application\Command;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Cli\CommandController;
use Wwwision\Users\Domain\Aggregate\User\Command\MakeUserAdministrator;
use Wwwision\Users\Domain\Aggregate\User\Command\RenameUser;
use Wwwision\Users\Domain\Aggregate\User\Command\SignUpUser;
use Wwwision\Users\Domain\Aggregate\User\UserCommandHandler;

class UserCommandController extends CommandController
{
    /**
     * @Flow\Inject
     * @var UserCommandHandler
     */
    protected $userCommandHandler;

    /**
     * @param string $userId
     * @return void
     */
    public function makeAdminCommand(string $userId)
    {
        $command = new MakeUserAdministrator($userId);
        $this->userCommandHandler->handleMakeUserAdministrator($command);
        $this->outputLine('Made user "%s" an administrator', [$command->getUserId()]);
    }
}