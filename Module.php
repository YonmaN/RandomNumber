<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/RandomNumber for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace RandomNumber;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use ZendServer\Log\Log;
use Zend\EventManager\Event;

class Module implements AutoloaderProviderInterface, BootstrapListenerInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }
    
	/* (non-PHPdoc)
	 * @see \Zend\ModuleManager\Feature\BootstrapListenerInterface::onBootstrap()
	 */
	public function onBootstrap(\Zend\EventManager\EventInterface $e) {
		if ($e->getParam('devbar',false)) {
		    Log::alert(__METHOD__);
		    $app = $e->getApplication(); /* @var $app \Zend\Mvc\Application */
		    $events = $app->getEventManager();
		    $randomNumber = new RandomNumber();
		    /// register at least before EVENT_DISPATCH
		    $events->attach('DevBarModules', function (Event $e) use ($randomNumber) {
		    	return array(__NAMESPACE__ => $randomNumber->random());
		    });
		}
	}
}
