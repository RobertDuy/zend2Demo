<?php

namespace Album\Api;

use Zend\Http\Response;;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Http\Client;
use Zend\Http\Client\Adapter\Curl;
use Zend\Db\ResultSet\ResultSet;
use SomeApi;

class SomeApiService implements ServiceManagerAwareInterface {
    protected $httpClient;
    protected $serviceManager;

    public function __construct(){
        $this->httpClient = new Client();
        $adapter = new Curl;
        $adapter->setOptions(array(CURLOPT_FOLLOWLOCATION => true));
        $this->httpClient->setAdapter($adapter);
    }

    public function setServiceManager(ServiceManager $serviceManager){
        $this->serviceManager = $serviceManager;
    }

    public function send(SomeApi $api){
        $this->httpClient->setRawBody($api); //calls $api::__toString()
        $response = $this->httpClient->send();

        // Instance of class "Response"
        $apiResponse = $this->serviceManager->get(get_class($api) . "Response");

        return $apiResponse->setData($response->getBody());
    }

    public function setHttpClient(Client $httpClient){
        $this->httpClient = $httpClient;
        return $this;
    }

    public function getSomethingUseful(){
        // You can use AdapterInterface $adapter from ServiceManager for query DB

        $dbAdapter = $this->serviceManager->get('Zend\Db\Adapter\Adapter');
        $statement = $dbAdapter->createStatement('SELECT * FROM album', null);
        $query = $statement->execute();
        $resultSet = new ResultSet;
        $resultSet->initialize($query);
        return $resultSet;
    }
}