<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Certificate\Form;

use Zend\Form\Form;
use Doctrine\ORM\EntityManager;

/**
 * Description of CertificateForm
 *
 * @author weeam
 */
class CertificateForm extends Form {

    protected $entityManager;

    public function __construct(EntityManager $entityManager) {

        parent::__construct('Certificate');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'ISIN',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'ISIN',
                'id' => 'ISIN'
            ),
        ));

        $this->add(array(
            'name' => 'trading_market',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Market',
                'multiple' => false,
                'id' => 'trading_market'
            ),
            'options' => array(
                'object_manager' => $this->entityManager,
                'target_class' => 'Market\Model\Market',
                'property' => 'xname',
            ),
        ));

        $this->add(array(
            'name' => 'currency',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Currency',
                'multiple' => false,
                'id' => 'currency'
            ),
            'options' => array(
                'object_manager' => $this->entityManager,
                'target_class' => 'Currency\Model\Currency',
                'property' => 'code',
            ),
        ));

        $this->add(array(
            'name' => 'issuer',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Issuer',
                'multiple' => false,
                'id' => 'issuer'
            ),
            'options' => array(
                'object_manager' => $this->entityManager,
                'target_class' => 'Issuer\Model\Issuer',
                'property' => 'xname',
            ),
        ));

        $this->add(array(
            'name' => 'issuerprice',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Issuer Price',
                'id' => 'issuerprice'
            ),
        ));

        $this->add(array(
            'name' => 'currentprice',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Current Price',
                'id' => 'currentprice'
            ),
        ));

        $this->add(array(
            'name' => 'certificatetype',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Certificate Type',
                'id' => 'certificatetype'
            ),
            'options' => array(
                'value_options' => array(
                    '0' => 'Stander',
                    '1' => 'Bonus Certificate',
                    '2' => 'Guarantee Certificate',
                ),
            )
        ));

        $this->add(array(
            'name' => 'participationrate',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Participation Rate',
                'id' => 'participationrate'
            ),
        ));

        $this->add(array(
            'name' => 'barrierlevel',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Barrier Level',
                'id' => 'barrierlevel'
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }

}
