<?php
namespace Wwwision\Users\Domain\Service;

use Doctrine\DBAL\DBALException;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\PersistenceManagerInterface;
use TYPO3\Flow\Security\Account;
use TYPO3\Flow\Security\AccountRepository;
use TYPO3\Flow\Security\Context;
use TYPO3\Flow\Security\Policy\PolicyService;

/**
 * @Flow\Scope("singleton")
 *
 * @internal This service is meant to be used by this package exclusively
 */
final class AccountService
{
    /**
     * @Flow\Inject
     * @var AccountRepository
     */
    protected $accountRepository;

    /**
     * @Flow\Inject
     * @var Context
     */
    protected $securityContext;

    /**
     * @Flow\Inject
     * @var PersistenceManagerInterface
     */
    protected $persistenceManager;

    /**
     * @Flow\Inject
     * @var PolicyService
     */
    protected $policyService;

    /**
     * @var string
     */
    const AUTHENTICATION_PROVIDER_NAME = 'DefaultProvider';

    public function createAccount(string $identifier, string $hashedPassword): Account
    {
        $account = new Account();
        $account->setAccountIdentifier($identifier);
        $account->setCredentialsSource($hashedPassword);
        $account->setAuthenticationProviderName(self::AUTHENTICATION_PROVIDER_NAME);

        $account->addRole($this->policyService->getRole('Wwwision.Users:User'));

        $this->accountRepository->add($account);
        $this->persistenceManager->whitelistObject($account);
        try {
            $this->persistenceManager->persistAll(true);
        } catch (DBALException $exception) {
            throw new \RuntimeException(sprintf('An account with the identifier "%s" already exists!', $identifier), 1477230243);
        }
        return $account;
    }

    public function makeAdministrator(string $identifier)
    {
        $account = $this->getAccount($identifier);
        $account->addRole($this->policyService->getRole('Wwwision.Users:Administrator'));
        $this->accountRepository->update($account);
        $this->persistenceManager->whitelistObject($account);
        $this->persistenceManager->persistAll(true);
    }

    public function getAccount(string $identifier): Account
    {
        $account = null;
        $this->securityContext->withoutAuthorizationChecks(function () use ($identifier, &$account) {
            $account = $this->accountRepository->findActiveByAccountIdentifierAndAuthenticationProviderName($identifier, self::AUTHENTICATION_PROVIDER_NAME);
        });
        if ($account === null) {
            throw new \InvalidArgumentException(sprintf('An account with the identifier "%s" does not exist!', $identifier), 1477230407);
        }
        return $account;
    }

    public function hasAccount(string $identifier): bool
    {
        $account = null;
        $this->securityContext->withoutAuthorizationChecks(function () use ($identifier, &$account) {
            $account = $this->accountRepository->findByAccountIdentifierAndAuthenticationProviderName($identifier, self::AUTHENTICATION_PROVIDER_NAME);
        });
        return $account !== null;
    }

    public function updatePassword(Account $account, string $hashedPassword)
    {
        $account->setCredentialsSource($hashedPassword);
        $this->accountRepository->update($account);
    }

    public function isAuthenticated(): bool
    {
        return $this->securityContext->getAccountByAuthenticationProviderName(self::AUTHENTICATION_PROVIDER_NAME) !== null;
    }

    public function getAuthenticatedAccount(): Account
    {
        return $this->securityContext->getAccountByAuthenticationProviderName(self::AUTHENTICATION_PROVIDER_NAME);
    }

    public function getAuthenticatedAccountId()
    {
        if (!$this->isAuthenticated()) {
            return null;
        }
        return $this->getAuthenticatedAccount()->getAccountIdentifier();
    }

}