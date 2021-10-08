<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Currency\Form;

use Zend\Form\Form;

/**
 * Description of IssuerForm
 *
 * @author Alabbas
 */
class CurrencyForm extends Form {

    public function __construct($name = null) {

        parent::__construct('Currency');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'xname',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Name',
                'id' => 'name'
            ),
        ));

        $this->add(array(
            'name' => 'code',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Name',
                'id' => 'name'
            ),
        ));

        $this->add(array(
            'name' => 'symbol',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Name',
                'id' => 'name'
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
