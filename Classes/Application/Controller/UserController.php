<?php
namespace Wwwision\Users\Application\Controller;

use Neos\Cqrs\EventStore\Exception\ConcurrencyException;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Error\Message;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Wwwision\Users\Domain\Aggregate\User\Command\RenameUser;
use Wwwision\Users\Domain\Aggregate\User\Command\SignUpUser;
use Wwwision\Users\Domain\Aggregate\User\UserCommandHandler;
use Wwwision\Users\Projection\User\User;
use Wwwision\Users\Projection\User\UserFinder;

class UserController extends ActionController
{
    /**
     * @Flow\Inject
     * @var UserCommandHandler
     */
    protected $userCommandHandler;

    /**
     * @Flow\Inject
     * @var UserFinder
     */
    protected $userFinder;

    public function indexAction()
    {
        $this->view->assign('users', $this->userFinder->findAll());
    }

    public function showAction(User $user)
    {
        $this->view->assign('user', $user);
    }

    public function signUpAction(SignUpUser $command)
    {
        $this->userCommandHandler->handleSignUpUser($command);
        $this->addFlashMessage('Signed up user "%s"', 'Success', Message::SEVERITY_OK, [$command->getName()]);
        $this->redirect('index');
    }

    public function renameAction(RenameUser $command)
    {
        try {
            $this->userCommandHandler->handleRenameUser($command);
            $this->addFlashMessage('Renamed user to "%s"', 'Success', Message::SEVERITY_OK, [$command->getNewName()]);
        } catch (ConcurrencyException $exception) {
            $this->addFlashMessage('The user has been updated in the meantime, reloading', 'Error', Message::SEVERITY_ERROR, [$command->getNewName()]);
        }
        $this->redirect('show', null, null, ['user' => $command->getUserId()]);
    }

    protected function getErrorFlashMessage() : bool
    {
        return false;
    }


}