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
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\View\Model\ViewModel;

class Module implements AutoloaderProviderInterface, BootstrapListenerInterface, ConfigProviderInterface
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
		    $events = $app->getEventManager()->getSharedManager();
		    /// register before EVENT_DISPATCH at the latest
		    $events->attach('devbar', 'DevBarModules', function (Event $e) {
    		    $randomNumber = new RandomNumber();
    		    $viewModel = new ViewModel(array('randomnumber' => $randomNumber->random()));
    		    $viewModel->setTemplate('random/randomnumber.phtml');
		    	return $viewModel;
		    });
		}
	}
	/* (non-PHPdoc)
	 * @see \Zend\ModuleManager\Feature\ConfigProviderInterface::getConfig()
	 */
	public function getConfig() {
		return array(
            	'view_manager' => array(
            		'template_path_stack' => array(
            				__DIR__ . '/views',
            		),
            	),
            );
	}

}
