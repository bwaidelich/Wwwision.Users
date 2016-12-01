<?php
namespace Wwwision\Users\Application\Controller;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\ActionRequest;
use Neos\Flow\Security\Authentication\Controller\AbstractAuthenticationController;

class AuthenticationController extends AbstractAuthenticationController
{
    protected function onAuthenticationSuccess(ActionRequest $originalRequest = null)
    {
        if ($originalRequest !== null) {
            $this->redirectToRequest($originalRequest);
        }
        $this->redirect('index', 'User');
    }

    public function logoutAction()
    {
        parent::logoutAction();
        $this->redirect('index', 'User');
    }
}