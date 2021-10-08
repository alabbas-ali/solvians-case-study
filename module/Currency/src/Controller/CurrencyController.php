<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Currency\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;

/**
 * Description of IssuerController
 *
 * @author Alabbas
 */
class CurrencyController extends AbstractActionController {

     /**
     *
     * @var Doctrine\ORM\EntityManager 
     */
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function indexAction() {
        return new ViewModel();
    }

    public function addAction() {
        
    }

    public function editAction() {
        
    }

    public function deleteAction() {
        
    }

    public function chstatusAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return new JsonModel(array("done" => 'false', 'message' => 'Sorry but can not edit this'));
        }

        $currency = $this->em->find('Currency\Model\Currency', $id);
        if ($currency) {
            $currency->active = !$currency->active;
            $this->em->flush();
            return new JsonModel(array("done" => 'true', 'message' => 'Currency has been edited'));
        }
        return new JsonModel(array("done" => 'false', 'message' => 'Sorry but can not edit this'));
    }

}
