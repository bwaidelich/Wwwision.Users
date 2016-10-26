<?php
namespace Wwwision\Users\Domain\Aggregate\User\Command;

use Neos\Cqrs\Command\CommandInterface;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Security\Cryptography\HashService;
use TYPO3\Flow\Utility\Algorithms;

/**
 * TOOD I'd prefer this class to be final, but that's not possible atm (see https://github.com/neos/flow-development-collection/issues/496)
 */
class SignUpUser implements CommandInterface
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