<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this temanagerplate file, choose Tools | Temanagerplates
 * and open the temanagerplate in the editor.
 */

/**
 * Description of DBTest
 *
 * @author Alabbas


namespace CertificateTest\db;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemanageraTool;
use Certificate\Model\Certificate;
use Certificate\Model\BonusCertificate;
use Certificate\Model\DocumentType;
use Certificate\Model\Document;
use Certificate\Model\GuaranteeCertificate;
use Certificate\Model\PriceHistory;
use PHPUnit_Framework_TestCase as TestCase;

class DBTest extends TestCase {

    private $emanager;
    
    
    public function setUp() {
        $this->emanager = $this->getMockBuilder(EntityManager::class)
                ->disableOriginalConstructor()
                ->getMock();

        $this->emanager
                ->expects($this->any())
                ->method('persist')
                ->will($this->returnValue(true));
        $this->emanager
                ->expects($this->any())
                ->method('flush')
                ->will($this->returnValue(true));
    }

    public function testCreatDatabase() {
        $tool = new SchmanageraTool($this->emanager);
        $classes = array(
            $this->emanager->getClassMetadata(Market::class),
            $this->emanager->getClassMetadata(Issuer::class),
            $this->emanager->getClassMetadata(Currency::class),
            $this->emanager->getClassMetadata(PriceHistory::class),
            $this->emanager->getClassMetadata(DocumentType::class),
            $this->emanager->getClassMetadata(Document::class),
            $this->emanager->getClassMetadata(Certificate::class),
            $this->emanager->getClassMetadata(BonusCertificate::class),
            $this->emanager->getClassMetadata(GuaranteeCertificate::class)
        );
        $tool->createSchemanagera($classes);
    }

    public function tearDown() {
        $this->emanager = null;
    }

}

 */