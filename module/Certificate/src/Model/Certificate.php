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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Certificate\Model\Document;
use Certificate\Model\PriceHistory;

/**
 * @ORM\Entity
 * @ORM\Table(name="Certificate")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="certificatetype", type="integer")
 * @ORM\DiscriminatorMap({"1" = "Certificate", "2" = "BonusCertificate" , "3" = "GuaranteeCertificate"})
 */
class Certificate implements InputFilterAwareInterface {
    /*
     * 
     */

    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $ISIN;

    /**
     * @ORM\ManyToOne(targetEntity="Market\Model\Market")
     * @ORM\JoinColumn(name="market_id", referencedColumnName="id")
     * */
    protected $trading_market;

    /**
     * @ORM\ManyToOne(targetEntity="Currency\Model\Currency")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     * */
    protected $currency;

    /**
     * @ORM\ManyToOne(targetEntity="Issuer\Model\Issuer")
     * @ORM\JoinColumn(name="issuer_id", referencedColumnName="id")
     * */
    protected $issuer;

    /** @ORM\Column(type="float") */
    protected $issuerprice;

    /** @ORM\Column(type="float") */
    protected $currentprice;

    /**
     * @ORM\OneToMany(targetEntity="Certificate\Model\Document", mappedBy="certificate", cascade={"remove"} ,fetch="EXTRA_LAZY")
     */
    protected $documents;

    /**
     * @ORM\OneToMany(targetEntity="Certificate\Model\PriceHistory", mappedBy="certificate", cascade={"remove"} , fetch="EXTRA_LAZY")
     */
    protected $pricehistory;

    /** @ORM\Column(type="boolean") */
    protected $active;

    public function getDocuments() {
        return $this->documents->toArray();
    }

    public function addDocument(Document $document) {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
        }
        return $this;
    }

    public function removeDocument(Document $document) {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
        }
        return $this;
    }
    
    public function getPriceHistory() {
        return $this->pricehistory->toArray();
    }

    public function addPriceHistory(PriceHistory $price) {
        if (!$this->pricehistory->contains($price)) {
            $this->pricehistory->add($price);
        }
        return $this;
    }

    public function removePriceHistory(PriceHistory $price) {
        if ($this->pricehistory->contains($price)) {
            $this->pricehistory->removeElement($price);
        }
        return $this;
    }

    public function __construct() {
        $this->documents = new ArrayCollection();
        $this->pricehistory = new ArrayCollection();
    }

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

    /**
     * @param array $data
     */
    public function exchangeArray($data = array()) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->ISIN = (isset($data['ISIN'])) ? $data['ISIN'] : null;
        $this->trading_market = (isset($data['trading_market'])) ? $data['trading_market'] : null;
        $this->currency = (isset($data['currency'])) ? $data['currency'] : null;
        $this->issuer = (isset($data['issuer'])) ? $data['issuer'] : null;
        $this->issuerprice = (isset($data['issuerprice'])) ? $data['issuerprice'] : null;
        $this->currentprice = (isset($data['currentprice'])) ? $data['currentprice'] : null;
        $this->documents = (isset($data['documents'])) ? $data['documents'] : null;
        $this->pricehistory = (isset($data['pricehistory'])) ? $data['pricehistory'] : null;
        $this->active = (isset($data['active'])) ? $data['active'] : null;
    }

    /**
     * 
     * Set input filter
     *
     * @param Zend\InputFilter\InputFilterInterface $inputFilter
     * We only need to implement getInputFilter() so we throw an exception from setInputFilter()
     * @throws DomainException
     */
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new DomainException(sprintf(
                '%s does not allow injection of an alternate input filter', __CLASS__
        ));
    }

    /**
     * Retrieve input filter
     *
     * @return Zend\InputFilter\InputFilter
     */
    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'ISIN',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'regex',
                        'options' => array(
                            'pattern' => '/[A-Z]{2}[0-9A-Z]{10}/',
                            'messages' => array('regexNotMatch' => 'This is not path'),
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'issuerprice',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Float',
                        'options' => array(
                            'min' => 0,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'currentprice',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Float',
                        'options' => array(
                            'min' => 0,
                        ),
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }

}
