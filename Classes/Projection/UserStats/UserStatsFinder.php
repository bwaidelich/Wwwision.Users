<?php
namespace Wwwision\Users\Projection\UserStats;

use Neos\Cqrs\Projection\Doctrine\AbstractDoctrineFinder;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\QueryInterface;

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