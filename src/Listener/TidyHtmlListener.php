<?php
/**
 *
 */
namespace App\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Class TidyHtmlListener
 * @package App\Listener
 */
class TidyHtmlListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ResponseListener constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $html
     *
     * @return bool|string
     */
    public function tidyHtml($html)
    {
        $dom = new \DOMDocument();
        if (libxml_use_internal_errors(true) === true) {
            libxml_clear_errors();
        }
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        $html = preg_replace(array('~\R~u', '~>[[:space:]]++<~m'), ["\n", '><'], $html);
        if ((empty($html) !== true) && ($dom->loadHTML($html) === true)) {
            $dom->formatOutput = true;
            if (($html = $dom->saveXML($dom->documentElement, LIBXML_NOEMPTYTAG)) !== false) {
                $regex = [
                    '~' . preg_quote('<![CDATA[', '~') . '~' => '',
                    '~' . preg_quote(']]>', '~') . '~' => '',
                    '~></(?:area|base(?:font)?|br|col|command|embed|frame|hr|img|input|keygen|link|meta|param|source|track|wbr)>~' => ' />',
                ];

                return '<!DOCTYPE html>' . "\n" . preg_replace(array_keys($regex), $regex, $html);
            }
        }

        return false;
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event) {
        $request = $event->getRequest();
        if ($request->getRequestFormat() == 'html') {
            $event->getResponse()->setContent($this->tidyHtml($event->getResponse()->getContent()));
        }
    }
}