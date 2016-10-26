<?php
namespace Wwwision\Users\Application\Service;

use Neos\Cqrs\Command\CommandInterface;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\AOP\JoinPointInterface;
use TYPO3\Flow\Log\SystemLoggerInterface;
use TYPO3\Flow\Utility\TypeHandling;

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
     * @Flow\Before("within(Neos\Cqrs\Command\CommandHandlerInterface) && method(.*->handle.*())")
     */
    public function beforeCommandHandling(JoinPointInterface $joinPoint)
    {
        /** @var CommandInterface $command */
        $arguments = array_values($joinPoint->getMethodArguments());
        $command = array_shift($arguments);
        $this->systemLogger->log('Handling command "' . TypeHandling::getTypeForValue($command) . '"', LOG_INFO, ['command' => $command]);
    }
}