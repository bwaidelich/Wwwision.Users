<?php
namespace Wwwision\Users\Projection\UserStats;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Entity
 * @ORM\Table(name="wwwision_users_userstats")
 */
class UserStats
{
    /**
     * @ORM\Id
     * @var string
     */
    protected $id;

    /**
     * @var \DateTimeInterface
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $name;

    public function __construct(string $id, \DateTimeInterface $timestamp, string $name)
    {
        $this->id = $id;
        $this->timestamp = $timestamp;
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTimestamp(): \DateTimeInterface
    {
        return $this->timestamp;
    }

}