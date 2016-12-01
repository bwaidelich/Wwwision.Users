<?php
namespace Wwwision\Users\Projection\User;

use Neos\Cqrs\EventStore\RawEvent;
use Neos\Cqrs\Projection\Doctrine\AbstractDoctrineProjector;
use Neos\Flow\Annotations as Flow;
use Wwwision\Users\Domain\Aggregate\User\Event\UserHasSignedUp;
use Wwwision\Users\Domain\Aggregate\User\Event\UserWasRenamed;
use Wwwision\Users\Domain\Service\AccountService;

/**
 * @method User get($identifier)
 */
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

    public function whenUserWasRenamed(UserWasRenamed $event, RawEvent $rawEvent)
    {
        $user = $this->get($event->getUserIdentifier());
        $user->_setName($event->getNewName());
        $user->_setVersion($rawEvent->getVersion());
        $this->update($user);
    }
}