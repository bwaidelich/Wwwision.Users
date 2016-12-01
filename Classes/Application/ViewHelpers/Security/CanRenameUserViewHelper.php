<?php
namespace Wwwision\Users\Application\ViewHelpers\Security;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Aop\JoinPoint;
use Neos\Flow\Security\Authorization\Privilege\Method\MethodPrivilegeInterface;
use Neos\Flow\Security\Authorization\Privilege\Method\MethodPrivilegeSubject;
use Neos\Flow\Security\Authorization\PrivilegeManagerInterface;
use Neos\FluidAdaptor\Core\ViewHelper\AbstractConditionViewHelper;
use Wwwision\Users\Domain\Aggregate\User\User;
use Wwwision\Users\Domain\Aggregate\User\UserRepository;

class CanRenameUserViewHelper extends AbstractConditionViewHelper
{
    /**
     * @Flow\Inject
     * @var PrivilegeManagerInterface
     */
    protected $privilegeManager;

    /**
     * @Flow\Inject
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param string $userId
     * @return string
     */
    public function render($userId)
    {
        $user = $this->userRepository->get($userId);
        $mockJoinPoint = new JoinPoint($user, User::class, 'rename', []);
        $subject = new MethodPrivilegeSubject($mockJoinPoint);
        if ($this->privilegeManager->isGranted(MethodPrivilegeInterface::class, $subject)) {
            return $this->renderThenChild();
        }
        return $this->renderElseChild();
    }
}