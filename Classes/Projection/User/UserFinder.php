<?php
namespace Wwwision\Users\Projection\User;

use Neos\Cqrs\Projection\Doctrine\AbstractDoctrineFinder;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\QueryInterface;

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