<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AlbumController extends AbstractActionController
{
    protected $albumTable;

    public function indexAction()
    {
        #===============================================
        #This is how to get Data form DataTabledMapping (look like Hibernate)
        #===============================================
        #return new ViewModel(array(
        #    'albums' => $this->getAlbumTable()->fetchAll(),
        #));

        #===============================================
        #This is how to call a service like another framework
        #===============================================
        $serviceManager = $this->getServiceLocator();
        $apiServiceResult = $serviceManager->get('SomeApiService')->getSomethingUseful();
        return new ViewModel(array('albums' => $apiServiceResult));
    }

    public function addAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }

    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }

}