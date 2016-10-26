<?php
namespace Wwwision\Users\Domain\Validation;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Validation\Validator\AbstractValidator;
use Wwwision\Users\Domain\Service\AccountService;

class UniqueUsernameValidator extends AbstractValidator
{
    /**
     * @Flow\inject
     * @var AccountService
     */
    protected $accountService;

    /**
     * @param string $username
     * @return void
     */
    protected function isValid($username)
    {
        if ($this->accountService->hasAccount($username)) {
            $this->addError('The username "%s" is already registered', 1477493891, [$username]);
        }
    }
}