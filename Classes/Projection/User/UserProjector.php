<?php
namespace Wwwision\Users\Projection\User;

use Neos\Cqrs\Event\EventMetadata;
use Neos\Cqrs\Projection\Doctrine\AbstractDoctrineProjector;
use TYPO3\Flow\Annotations as Flow;
use Wwwision\Users\Domain\Aggregate\User\Event\UserHasSignedUp;
use Wwwision\Users\Domain\Aggregate\User\Event\UserWasRenamed;
use Wwwision\Users\Domain\Service\AccountService;

class UserProjector extends AbstractDoctrineProjector
{
    /**
     * @Flow\Inject
     * @var AccountService
     */
    protected $accountService;

    public function whenUserHasSignedUp(UserHasSignedUp $event)
    {
        $account = $this->accountService->getAccount($event->getUsername());
        $user = new User($event->getUserIdentifier(), $event->getName(), $account);
        $this->add($user);
    }

    public function whenUserWasRenamed(UserWasRenamed $event, EventMetadata $metadata)
    {
        $user = $this->get($event->getUserIdentifier());
        $user->_setName($event->getNewName());
        $user->_setVersion($metadata->getProperty(EventMetadata::VERSION));
        $this->update($user);
    }

    public function get(string $userIdentifier): User
    {
        /** @var User $user */
        $user = parent::get($userIdentifier);
        return $user;
    }
}