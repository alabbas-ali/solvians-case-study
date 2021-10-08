<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 * @author ِAlabbas
 */

namespace Certificate\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="GuaranteeCertificate")
 */
class GuaranteeCertificate extends Certificate{
    
    /** @ORM\Column(type="integer") */
    protected $participationrate;
    
    function getParticipationrate() {
        return $this->participationrate;
    }
    
    function setParticipationrate($participationrate) {
        $this->participationrate = $participationrate;
    }
    
    /**
     * @return array
     */
    public function getArrayCopy() {
        $data = array();
        foreach ($this as $key => $value) {
            if (is_object($value) && !is_a($value, PersistentCollection::class) && $key != 'inputFilter') {
                $data[$key] = $value->getArrayCopy();
            } else if (is_object($value) && is_a($value, PersistentCollection::class)) {
                //var_dump($value); die();
                //foreach ($value as $ob) {
                //   $data[$key] = $ob->getArrayCopy();
                //}
            } else {
                $data[$key] = $value;
            }
        }
        return $data;
    }
}
