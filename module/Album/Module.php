<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Album;

// Add these import statements:
use Album\Model\Album;
use Album\Model\AlbumTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
    	return array(
    			'Zend\Loader\ClassMapAutoloader' => array(
    					__DIR__ . '/autoload_classmap.php',
    			),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'Album\Model\AlbumTable' =>  function($sm) {
    					$tableGateway = $sm->get('AlbumTableGateway');
    					$table = new AlbumTable($tableGateway);
    					return $table;
    	},
    	'AlbumTableGateway' => function ($sm) {
    	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    	$resultSetPrototype = new ResultSet();
    	$resultSetPrototype->setArrayObjectPrototype(new Album());
    	return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
    	},
    	),
    	);
    }
}
