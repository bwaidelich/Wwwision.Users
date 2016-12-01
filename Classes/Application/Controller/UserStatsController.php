<?php
namespace Wwwision\Users\Application\Controller;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
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