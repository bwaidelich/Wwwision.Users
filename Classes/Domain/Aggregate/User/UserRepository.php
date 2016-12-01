<?php
namespace Wwwision\Users\Domain\Aggregate\User;

use Neos\Cqrs\EventStore\AbstractEventSourcedRepository;
use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 *
 * @method User get(string $identifier)
 */
final class UserRepository extends AbstractEventSourcedRepository
{

}