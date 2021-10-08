<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Certificate\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

/**
 * Description of DocumentController
 *
 * @author weeam
 */
class DocumentController extends AbstractActionController {
    
    /**
     *
     * @var Doctrine\ORM\EntityManager 
     */
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function indexAction() {
        
    }

    public function addAction() {
        
    }

    public function editAction() {
        
    }

    public function deleteAction() {
        
    }

}
