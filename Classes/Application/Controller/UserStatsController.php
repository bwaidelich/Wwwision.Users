<?php
namespace Wwwision\Users\Application\Controller;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Wwwision\Users\Projection\UserStats\UserStatsFinder;

class UserStatsController extends ActionController
{
    /**
     * @Flow\Inject
     * @var UserStatsFinder
     */
    protected $userStatsFinder;

    public function indexAction()
    {
        $this->view->assign('userStats', $this->userStatsFinder->findAll());
    }

    protected function getErrorFlashMessage() : bool
    {
        return false;
    }


}