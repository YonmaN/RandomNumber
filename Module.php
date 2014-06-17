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
use ZendServer\Log\Log;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use DevBar\ModuleManager\Feature\DevBarProducerProviderInterface;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, DevBarProducerProviderInterface, ServiceProviderInterface, BootstrapListenerInterface
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
	 * @see \Zend\ModuleManager\Feature\ConfigProviderInterface::getConfig()
	 */
	public function getConfig() {
		return include "config/module.config.php";
	}
	
	/* (non-PHPdoc)
	 * @see \DevBar\ModuleManager\Feature\DevBarModuleProviderInterface::getDevBarProducers()
	 */
	public function getDevBarProducers(EventInterface $e) {
	    $sm = $e->getApplication()->getServiceManager();
		return array($sm->get('RandomNumber\DevBarProducer'));
	}
	
	/* (non-PHPdoc)
	 * @see \Zend\ModuleManager\Feature\ServiceProviderInterface::getServiceConfig()
	 */
	public function getServiceConfig() {
		return array(
			'invokables' => array('RandomNumber\DevBarProducer' => 'RandomNumber\DevBarProducer')
		);
	}


	/*
	 * (non-PHPdoc)
	 * @see \Zend\ModuleManager\Feature\BootstrapListenerInterface::onBootstrap()
	 */
	public function onBootstrap(EventInterface $e) {
	    /// add ACL entries
	    $serviceManager = $e->getApplication()->getServiceManager();
	    $identityAcl = $serviceManager->get('ZendServerIdentityAcl');
	    $identityAcl->addResource('route:RandomNumber');
	    $identityAcl->allow('administrator', 'route:RandomNumber');
	    $identityAcl->allow('devbar', 'route:RandomNumber');
	    $licenseAcl = $serviceManager->get('ZendServerLicenseAcl');
	    $licenseAcl->addResource('route:RandomNumber');
	    $licenseAcl->allow(null, 'route:RandomNumber');
	}

}
