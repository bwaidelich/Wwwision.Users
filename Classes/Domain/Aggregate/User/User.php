<?php
namespace Wwwision\Users\Domain\Aggregate\User;

use Neos\Cqrs\Domain\AbstractEventSourcedAggregateRoot;
use TYPO3\Flow\Annotations as Flow;
use Wwwision\Users\Domain\Aggregate\User\Event\UserHasSignedUp;
use Wwwision\Users\Domain\Aggregate\User\Event\UserWasMadeAdministrator;
use Wwwision\Users\Domain\Aggregate\User\Event\UserWasRenamed;
use Wwwision\Users\Domain\Service\AccountService;

final class User extends AbstractEventSourcedAggregateRoot
{
    /**
     * @Flow\Inject
     * @var AccountService
     */
    protected $accountService;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var bool
     */
    protected $admin = false;

    static public function signUp(string $identifier, string $name, string $username, string $hashedPassword) : User
    {
        $user = new User($identifier);
        $user->accountService->createAccount($username, $hashedPassword);

        $user->recordThat(new UserHasSignedUp($identifier, $name, $username, $hashedPassword));
        return $user;
    }

    protected function whenUserHasSignedUp(UserHasSignedUp $event)
    {
        $this->name = $event->getName();
        $this->username = $event->getUsername();
    }

    public function rename(string $newName)
    {
        if ($newName === $this->name) {
            return;
        }
        $this->recordThat(new UserWasRenamed($this->getIdentifier(), $newName, $this->name));
    }

    protected function whenUserWasRenamed(UserWasRenamed $event)
    {
        $this->name = $event->getNewName();
    }

    public function makeAdministrator()
    {
        if ($this->admin) {
            throw new \RuntimeException('This user is already an administrator!', 1474277109);
        }
        $this->accountService->makeAdministrator($this->username);
        $this->recordThat(new UserWasMadeAdministrator($this->getIdentifier()));
    }

    protected function whenUserWasMadeAdministrator()
    {
        $this->admin = true;
    }

    public function getUsername() : string
    {
        return $this->username;
    }

}