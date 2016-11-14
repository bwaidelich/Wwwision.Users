<?php
namespace Wwwision\Users\Projection\UserStats;

use Neos\Cqrs\EventListener\AsynchronousEventListenerInterface;
use Neos\Cqrs\EventStore\RawEvent;
use Neos\Cqrs\Projection\Doctrine\AbstractDoctrineProjector;
use TYPO3\Flow\Annotations as Flow;
use Wwwision\Users\Domain\Aggregate\User\Event\UserHasSignedUp;
use Wwwision\Users\Domain\Service\AccountService;

class UserStatsProjector extends AbstractDoctrineProjector implements AsynchronousEventListenerInterface
{
    /**
     * @Flow\Inject
     * @var AccountService
     */
    protected $accountService;

    public function whenUserHasSignedUp(UserHasSignedUp $event, RawEvent $rawEvent)
    {
        $userStats = new UserStats($event->getUserIdentifier(), $rawEvent->getRecordedAt(), $event->getName());
        $this->add($userStats);
    }
}