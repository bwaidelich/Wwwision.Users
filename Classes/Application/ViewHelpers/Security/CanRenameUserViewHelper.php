<?php
namespace Wwwision\Users\Application\ViewHelpers\Security;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Aop\JoinPoint;
use TYPO3\Flow\Security\Authorization\Privilege\Method\MethodPrivilegeInterface;
use TYPO3\Flow\Security\Authorization\Privilege\Method\MethodPrivilegeSubject;
use TYPO3\Flow\Security\Authorization\PrivilegeManagerInterface;
use TYPO3\Fluid\Core\ViewHelper\AbstractConditionViewHelper;
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