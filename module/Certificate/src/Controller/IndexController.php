<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Certificate\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;


class IndexController extends AbstractActionController {

    /**
     *
     * @var Doctrine\ORM\EntityManager 
     */
    protected $emanager;

    public function __construct(EntityManager $em) {
        $this->emanager = $em;
    }

    public function indexAction() {
        return new ViewModel();
    }

    public function initializeAction() {
        $dbcreater = new MockDateCreaterService($this->emanager);
        $dbcreater->creatDatabase();
        $dbcreater->insertMockMarkets();
        $dbcreater->insertMockIssuers();
        $dbcreater->insertMockCurrencies();
        $dbcreater->insertMockDocumentTypes();
        $dbcreater->insertMockCertificates();
        return $this->redirect()->toRoute('home');
    }

}
