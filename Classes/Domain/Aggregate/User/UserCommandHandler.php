<?php
namespace Wwwision\Users\Domain\Aggregate\User;

use Neos\Cqrs\EventStore\ExpectedVersion;
use Neos\Flow\Annotations as Flow;
use Wwwision\Users\Domain\Aggregate\User\Command\MakeUserAdministrator;
use Wwwision\Users\Domain\Aggregate\User\Command\RenameUser;
use Wwwision\Users\Domain\Aggregate\User\Command\SignUpUser;

/**
 * @Flow\Scope("singleton")
 */
final class UserCommandHandler
{
    /**
     * @Flow\Inject
     * @var UserRepository
     */
    protected $userRepository;

    public function handleSignUpUser(SignUpUser $command)
    {
        $user = User::signUp($command->getUserId(), $command->getName(), $command->getUsername(), $command->getHashedPassword());
        $this->userRepository->save($user, ExpectedVersion::NO_STREAM);
    }

    public function handleRenameUser(RenameUser $command)
    {
        $user = $this->userRepository->get($command->getUserId());
        $user->rename($command->getNewName());
        $this->userRepository->save($user, $command->getExpectedVersion());
    }

    public function handleMakeUserAdministrator(MakeUserAdministrator $command)
    {
        /** @var User $user */
        $user = $this->userRepository->get($command->getUserId());
        $user->makeAdministrator();
        $this->userRepository->save($user, ExpectedVersion::ANY);
    }
}