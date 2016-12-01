<?php
namespace Wwwision\Users\Application\Service;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Aop\JoinPointInterface;
use Neos\Flow\Log\SystemLoggerInterface;
use Neos\Utility\TypeHandling;

/**
 * @Flow\Aspect
 */
class CommandLoggerAspect
{

    /**
     * @Flow\Inject
     * @var SystemLoggerInterface
     */
    protected $systemLogger;

    /**
     * Logs all calls to CommandHandlerInterface::handle*() to the SystemLogger
     *
     * @Flow\Before("method(Wwwision\Users\Application\Command\UserCommandHandler->handle.*())")
     * @param JoinPointInterface $joinPoint
     */
    public function beforeCommandHandling(JoinPointInterface $joinPoint)
    {
        $arguments = array_values($joinPoint->getMethodArguments());
        $command = array_shift($arguments);
        $this->systemLogger->log('Handling command "' . TypeHandling::getTypeForValue($command) . '"', LOG_INFO, ['command' => $command]);
    }
}