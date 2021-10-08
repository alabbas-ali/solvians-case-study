<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * @author Alabbas
 */

namespace Certificate\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="PriceHistory")
 * 
 */
class PriceHistory {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Certificate\Model\Certificate", inversedBy="pricehistory")
     * @ORM\JoinColumn(name="certificate_id", referencedColumnName="id")
     */
    protected $certificate;


    /** @ORM\Column(type="datetime") */
    protected $updated_at;
    
    /** @ORM\Column(type="float") */
    protected $price;
    
    /**
     * @param string $property
     * @return mixed
     */
    public function __get($property) {
        return $this->$property;
    }

    /**
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value) {
        $this->$property = $value;
    }
    
    /**
     * @return array
     */
    public function getArrayCopy() {
        $data = array();
        $data['id'] = $this->id;
        $data['updated_at'] = $this->updated_at->format('Y-m-d H:i:s');;
        $data['price'] = $this->price;
        return $data;
    }

    /**
     * @param array $data
     */
    public function exchangeArray($data = array()) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->price = (isset($data['price'])) ? $data['price'] : null;
        $this->updated_at = (isset($data['updated_at'])) ? $data['updated_at'] : null;;
        $this->certificate = (isset($data['certificate'])) ? $data['certificate'] : null;;
    }
}
