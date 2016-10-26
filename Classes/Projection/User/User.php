<?php
namespace Wwwision\Users\Projection\User;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Security\Account;

/**
 * @Flow\Entity
 * @ORM\Table(name="wwwision_users_user")
 */
class User
{
    /**
     * @ORM\Id
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $version = 0;

    /**
     * @ORM\ManyToOne
     * @var Account
     */
    protected $account;

    public function __construct(string $id, string $name, Account $account)
    {
        $this->id = $id;
        $this->name = $name;
        $this->account = $account;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @return integer
     */
    public function getVersion()
    {
        return $this->version;
    }

    public function _setName(string $newName)
    {
        $this->name = $newName;
    }

    public function _setVersion(int $newVersion)
    {
        $this->version = $newVersion;
    }

}