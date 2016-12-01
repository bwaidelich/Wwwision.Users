<?php
namespace Wwwision\Users\Projection\UserStats;

use Neos\Cqrs\Projection\Doctrine\AbstractDoctrineFinder;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\QueryInterface;

/**
 * @Flow\Scope("singleton")
 */
class UserStatsFinder extends AbstractDoctrineFinder
{

	/**
	 * @var array
	 */
	protected $defaultOrderings = [
		'timestamp' => QueryInterface::ORDER_ASCENDING
	];

}