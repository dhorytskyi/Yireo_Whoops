<?php
/**
 * Whoops plugin for Magento
 *
 * @package     Yireo_Whoops
 * @author      Yireo (https://www.yireo.com/)
 * @copyright   Copyright 2016 Yireo (https://www.yireo.com/)
 * @license     Open Source License (OSL v3)
 */

namespace Yireo\Whoops\Plugin;

/**
 * Class HttpApp - Plugin for \Magento\Framework\App\Http
 */
class HttpApp
{
    /**
     * @var \Whoops\Run
     */
    private $whoopsRunner;

    /**
     * @var \Whoops\Handler\PrettyPageHandler
     */
    private $pageHandler;

    public function __construct(
        \Whoops\Run $whoopsRunner,
        \Whoops\Handler\PrettyPageHandler $pageHandler
    )
    {
        $this->whoopsRunner = $whoopsRunner;
        $this->pageHandler = $pageHandler;
    }

    public function beforeCatchException(
        \Magento\Framework\App\Http $subject,
        \Magento\Framework\App\Bootstrap $bootstrap,
        \Exception $exception
    )
    {
        if ($bootstrap->isDeveloperMode()) {

            // @todo: Create a configuration option for this
            //$handler = new \Whoops\Handler\PlainTextHandler;
            //$handler->setTraceFunctionArgsOutputLimit(64);
            $this->whoopsRunner->pushHandler($this->pageHandler);

            $this->whoopsRunner->handleException($exception);
        }

        return [$bootstrap, $exception];
    }
}
