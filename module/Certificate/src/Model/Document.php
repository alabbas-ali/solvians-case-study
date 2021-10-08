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
use DomainException;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="Document")
 */
class Document implements InputFilterAwareInterface {
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

    /** @ORM\Column(type="string") */
    protected $xname;

    /**
     * @ORM\Column(type="string")
     */
    protected $xpath;

    /**
     * @ORM\ManyToOne(targetEntity="Certificate\Model\DocumentType")
     * @ORM\JoinColumn(name="documenttype_id", referencedColumnName="id")
     * */
    protected $documenttype;

    /**
     * @ORM\ManyToOne(targetEntity="Certificate\Model\Certificate", inversedBy="documents")
     * @ORM\JoinColumn(name="certificate_id", referencedColumnName="id")
     */
    protected $certificate;

    /**  @ORM\Column(type="boolean") */
    protected $active;

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

            if (is_object($value) && $key != 'inputFilter') {
                $data[$key] = $value->getArrayCopy();
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
        $this->xname = (isset($data['xname'])) ? $data['xname'] : null;
        $this->xpath = (isset($data['xpath'])) ? $data['xpath'] : null;
        $this->documenttype = (isset($data['documenttype'])) ? $data['documenttype'] : null;
        $this->certificate = (isset($data['certificate'])) ? $data['certificate'] : null;
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
                'name' => 'xname',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'xpath',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'regex',
                        'options' => array(
                            'pattern' => '(https?:\/\/.+\/)(.+)(\.[a-zA-Z]{3})',
                            // '/\([0-9]{3}\)\s[0-9]{3}-[0-9]{4}/', 
                            'messages' => array('regexNotMatch' => 'This is not path'),
                        ),
                    ),
                ),
            ));


            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }

}
