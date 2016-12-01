<?php
namespace Wwwision\Users;

use Neos\Cqrs\Event\EventInterface;
use Neos\Cqrs\Event\EventPublisher;
use Neos\Flow\Core\Bootstrap;
use Neos\Flow\Http\HttpRequestHandlerInterface;
use Neos\Flow\Package\Package as BasePackage;

class Package extends BasePackage
{
    public function boot(Bootstrap $bootstrap)
    {
        $dispatcher = $bootstrap->getSignalSlotDispatcher();
        $dispatcher->connect(EventPublisher::class, 'beforePublishingEvent', function(EventInterface $_, array &$metadata) use ($bootstrap) {
            $requestHandler = $bootstrap->getActiveRequestHandler();
            if (!$requestHandler instanceof HttpRequestHandlerInterface) {
                return;
            }
            $request = $requestHandler->getHttpRequest();
            $metadata['ipAddress'] = $request->getClientIpAddress();
        });
    }

}