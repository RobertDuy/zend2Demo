<?php
namespace Album;

use Album\Model\Album;
use Album\Model\AlbumTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Http\Client\Adapter\Curl;
use Zend\Http\Client;
use Album\Api\SomeApiService;
use Album\Api\ConfigAwareInterface;

class Module
{
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

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
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
                'SomeApiService' => function($sm) {
                        $httpClient = new Client;
                        $httpClient->setAdapter(new Curl);

                        $client = new SomeApiService;
                        $client->setHttpClient($httpClient);

                        return $client;
                    }
            ),
            'invokables' => array(
                'SomeApi' => 'Album\Api\SomeApi'
            ),
            'shared' => array(
                // when you call $sm->get('SomeApi') we have new Instance of SomeApi object
                'someApi' => false
            ),
            'initializers' => array(
                function($instance, $sm) {
                    if($instance instanceof ConfigAwareInterface) {
                        $config = $sm->get('application')->getConfig();
                        $apiConfig = isset($config['api-config']) ? $config['api-config'] : array();
                        $instance->setConfig($apiConfig);
                    }
                }
            ),
            'abstract_factories' => array(
                'AbstractApiResponseFactory' => 'Album\Api\AbstractSomeApiResponseFactory'
            ),
        );
    }

}