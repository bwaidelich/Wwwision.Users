<?php
namespace Wwwision\Users\Domain\Aggregate\User\Command;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Security\Cryptography\HashService;
use Neos\Flow\Utility\Algorithms;

final class SignUpUser
{
    /**
     * @Flow\Validate(type="NotEmpty")
     * @var string
     */
    private $userId;

    /**
     * @Flow\Validate(type="NotEmpty")
     * @var string
     */
    private $name;

    /**
     * @Flow\Validate(type="NotEmpty")
     * @Flow\Validate(type="Wwwision\Users\Domain\Validation\UniqueUsernameValidator")
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @Flow\Validate(type="NotEmpty")
     * @var string
     */
    private $hashedPassword;

    /**
     * @Flow\Inject
     * @var HashService
     */
    protected $hashService;

    public function __construct(string $name, string $username, string $password)
    {
        $this->userId = Algorithms::generateUUID();
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
    }

    public function initializeObject()
    {
        if (!isset($this->password) || strlen($this->password) === 0) {
            return;
        }
        $this->hashedPassword = $this->hashService->hashPassword($this->password);
        $this->password = null;
    }

    public function getUserId() : string
    {
        return $this->userId;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getUsername() : string
    {
        return $this->username;
    }

    public function getHashedPassword()
    {
        return $this->hashedPassword;
    }

}