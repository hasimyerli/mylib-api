<?php


namespace App\EventListener;


use App\Response\ApiResponse\JsonFailureResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    private $environment;
    private $translator;

    public function __construct(KernelInterface $kernel, TranslatorInterface $translator)
    {
        $this->environment = $kernel->getEnvironment();
        $this->translator = $translator;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $e = $event->getThrowable();
        if ($e instanceof ApiException)
        {
            $jsonResponse = $e->getJsonFailureResponse()->getResponse();
        }
        else
        {
            if($this->environment !== 'prod')
            {
                return;
            }

            $jsonResponse = JsonFailureResponse::build()
                ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)
                ->setMessage($this->translator->trans('error.generic.unknown'))
                ->getResponse();

        }
        $jsonResponse->headers->set('Content-Type', 'application/problem+json');
        $event->setResponse($jsonResponse);
    }
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }
}