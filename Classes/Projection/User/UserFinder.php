<?php
namespace Wwwision\Users\Projection\User;

use Neos\Cqrs\Projection\Doctrine\AbstractDoctrineFinder;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\QueryInterface;

/**
 * @Flow\Scope("singleton")
 */
class UserFinder extends AbstractDoctrineFinder
{

	/**
	 * @var array
	 */
	protected $defaultOrderings = [
		'name' => QueryInterface::ORDER_ASCENDING
	];

}