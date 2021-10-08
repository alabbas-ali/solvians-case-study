<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Certificate\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\Collections\ArrayCollection;
use Certificate\Model\BonusCertificate;
use Certificate\Model\Certificate;
use Certificate\Model\Document;
use Certificate\Model\DocumentType;
use Certificate\Model\GuaranteeCertificate;
use Certificate\Model\PriceHistory;
use Currency\Model\Currency;
use Issuer\Model\Issuer;
use Market\Model\Market;

/**
 * Description of MockDateCreater
 *
 * @author Alabbas
 */
class MockDateCreaterService {

    /**
     *
     * @var Doctrine\ORM\EntityManager 
     */
    protected $emanager;

    public function __construct(EntityManager $em) {
        $this->emanager = $em;
    }

    /**
     * This Mathod creat the database schema (Tables ...)
     */
    public function creatDatabase() {

        $tool = new SchemaTool($this->emanager);
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
        $tool->createSchema($classes);
    }

    /**
     * Insert Mock data for test purpose 
     * this will insert five Markets
     */
    public function insertMockMarkets() {
        $market1 = new Market();
        $data1 = [ 'xname' => 'Frankfurt', 'active' => true];
        $market1->exchangeArray($data1);
        $market2 = new Market();
        $data2 = [ 'xname' => 'London', 'active' => true];
        $market2->exchangeArray($data2);
        $market3 = new Market();
        $data3 = ['xname' => 'Brussels', 'active' => true];
        $market3->exchangeArray($data3);
        $market4 = new Market();
        $data4 = ['xname' => 'Paris', 'active' => true];
        $market4->exchangeArray($data4);
        $market5 = new Market();
        $data5 = ['xname' => 'Berlin', 'active' => true];
        $market5->exchangeArray($data5);
        $this->emanager->persist($market1);
        $this->emanager->persist($market2);
        $this->emanager->persist($market3);
        $this->emanager->persist($market4);
        $this->emanager->persist($market5);
        $this->emanager->flush();
    }

    /**
     * Insert Mock data for test purpose 
     * this will insert four Issuers
     */
    public function insertMockIssuers() {
        $issuer1 = new Issuer();
        $data1 = [ 'xname' => 'American Express', 'active' => true];
        $issuer1->exchangeArray($data1);
        $issuer2 = new Issuer();
        $data2 = [ 'xname' => 'VISA', 'active' => true];
        $issuer2->exchangeArray($data2);
        $issuer3 = new Issuer();
        $data3 = ['xname' => 'Wells Fargo', 'active' => true];
        $issuer3->exchangeArray($data3);
        $issuer4 = new Issuer();
        $data4 = ['xname' => 'U.S. Bank', 'active' => true];
        $issuer4->exchangeArray($data4);
        $this->emanager->persist($issuer1);
        $this->emanager->persist($issuer2);
        $this->emanager->persist($issuer3);
        $this->emanager->persist($issuer4);
        $this->emanager->flush();
    }

    /**
     * Insert Mock data for test purpose 
     * this will insert four Currencies
     */
    public function insertMockCurrencies() {
        $currency1 = new Currency();
        $data1 = [ 'xname' => 'Dollar', 'code' => 'USD', 'symbol' => '$', 'active' => true];
        $currency1->exchangeArray($data1);
        $currency2 = new Currency();
        $data2 = [ 'xname' => 'Euro', 'code' => 'EUR', 'symbol' => '€', 'active' => true];
        $currency2->exchangeArray($data2);
        $currency3 = new Currency();
        $data3 = ['xname' => 'Fiji Dollar', 'code' => 'FJD', 'symbol' => '$', 'active' => true];
        $currency3->exchangeArray($data3);
        $currency4 = new Currency();
        $data4 = ['xname' => 'Pound', 'code' => 'FKP', 'symbol' => '£', 'active' => true];
        $currency4->exchangeArray($data4);
        $this->emanager->persist($currency1);
        $this->emanager->persist($currency2);
        $this->emanager->persist($currency3);
        $this->emanager->persist($currency4);
        $this->emanager->flush();
    }

    /**
     * Insert Mock data for test purpose 
     * this will insert tow Document Types
     */
    public function insertMockDocumentTypes() {
        $documentType1 = new DocumentType();
        $data1 = [ 'xname' => 'pdf', 'active' => true];
        $documentType1->exchangeArray($data1);
        $documentType2 = new DocumentType();
        $data2 = [ 'xname' => 'docx', 'active' => true];
        $documentType2->exchangeArray($data2);
        $this->emanager->persist($documentType1);
        $this->emanager->persist($documentType2);
        $this->emanager->flush();
    }

    /**
     * Insert Mock data for test purpose 
     * this will insert six certificates
     * Tow Certificates 
     * Tow BonusCertificate
     * Tow GuaranteeCertificate
     * also will mack soure to insert Documents and History Prices for this 
     * certificates
     */
    public function insertMockCertificates() {
        $this->insertMockCertificate('US0000RGDRT7', 1, 2, 3, 44.34, 86.49);
        $this->insertMockCertificate('US0378331005', 2, 3, 1, 45.36, 36.96);
        $this->insertMockBonusCertificate('US0000RGDRT8', 3, 2, 2, 45.37, 36.37, 79.39, true);
        $this->insertMockBonusCertificate('US0000RGDRT9', 4, 3, 3, 74.45, 46.69, 29.49, false);
        $this->insertMockGuaranteeCertificate('US0000RGDRT6', 2, 4, 4, 42.34, 43.99, 99);
        $this->insertMockGuaranteeCertificate('US0000RGDRT4', 3, 3, 1, 15.66, 72.99, 65);

        $this->insertMockDocument('doc 1', 'http://localhost:8080/uploads/filename_57d33a7dcbc07.pdf', 1, 1);
        $this->insertMockDocument('doc 2', 'http://localhost:8080/uploads/filename_57d33a7dcbc08.pdf', 1, 1);
        $this->insertMockDocument('doc 3', 'http://localhost:8080/uploads/filename_57d33a7dcbc07.pdf', 1, 2);
        $this->insertMockDocument('doc 4', 'http://localhost:8080/uploads/filename_57d33a7dcbc08.pdf', 1, 2);
        $this->insertMockDocument('doc 5', 'http://localhost:8080/uploads/filename_57d33a7dcbc07.pdf', 1, 2);
        $this->insertMockDocument('doc 6', 'http://localhost:8080/uploads/filename_57d33a7dcbc08.pdf', 1, 3);
        $this->insertMockDocument('doc 7', 'http://localhost:8080/uploads/filename_57d33a7dcbc07.pdf', 1, 3);
        $this->insertMockDocument('doc 8', 'http://localhost:8080/uploads/filename_57d33a7dcbc08.pdf', 1, 3);
        $this->insertMockDocument('doc 9', 'http://localhost:8080/uploads/filename_57d33a7dcbc07.pdf', 1, 4);
        $this->insertMockDocument('doc 11', 'http://localhost:8080/uploads/filename_57d33a7dcbc08.pdf', 1, 4);
        
        $date = new \DateTime("now");
        $this->insertMockPrice(1, 15.46, $date);
        $this->insertMockPrice(4, 24.35, $date);
        $this->insertMockPrice(2, 20.65, $date);
        $this->insertMockPrice(3, 48.56, $date);
        $this->insertMockPrice(4, 13.35, $date);
        $this->insertMockPrice(3, 88.34, $date);
        $this->insertMockPrice(1, 99.99, $date);
    }

    private function insertMockCertificate($ISIN, $mID, $cuID, $isID, $isPrice, $cuPrice) {
        $certificate = new Certificate();
        $market = $this->emanager->find(Market::class, $mID);
        $currency = $this->emanager->find(Currency::class, $cuID);
        $isser = $this->emanager->find(Issuer::class, $isID);
        $data = [
            'ISIN' => $ISIN,
            'trading_market' => $market,
            'currency' => $currency,
            'issuer' => $isser,
            'issuerprice' => $isPrice,
            'currentprice' => $cuPrice,
            'documents' => new ArrayCollection(),
            'pricehistory' => new ArrayCollection(),
            'active' => true
        ];
        $certificate->exchangeArray($data);
        $this->emanager->persist($certificate);
        $this->emanager->flush();
    }

    private function insertMockBonusCertificate($ISIN, $mID, $cuID, $isID, $isPrice, $cuPrice, $barrierlevel, $hit) {
        $certificate = new BonusCertificate();
        $market = $this->emanager->find(Market::class, $mID);
        $currency = $this->emanager->find(Currency::class, $cuID);
        $isser = $this->emanager->find(Issuer::class, $isID);
        $data = [
            'ISIN' => $ISIN,
            'trading_market' => $market,
            'currency' => $currency,
            'issuer' => $isser,
            'issuerprice' => $isPrice,
            'currentprice' => $cuPrice,
            'documents' => new ArrayCollection(),
            'pricehistory' => new ArrayCollection(),
            'active' => true
        ];
        $certificate->exchangeArray($data);
        $certificate->setBarrierlevel($barrierlevel);
        $certificate->setHit($hit);
        $this->emanager->persist($certificate);
        $this->emanager->flush();
    }

    private function insertMockGuaranteeCertificate($ISIN, $mID, $cuID, $isID, $isPrice, $cuPrice, $participationrate) {
        $certificate = new GuaranteeCertificate();
        $market = $this->emanager->find(Market::class, $mID);
        $currency = $this->emanager->find(Currency::class, $cuID);
        $isser = $this->emanager->find(Issuer::class, $isID);
        $data = [
            'ISIN' => $ISIN,
            'trading_market' => $market,
            'currency' => $currency,
            'issuer' => $isser,
            'issuerprice' => $isPrice,
            'currentprice' => $cuPrice,
            'documents' => new ArrayCollection(),
            'pricehistory' => new ArrayCollection(),
            'active' => true
        ];
        $certificate->exchangeArray($data);
        $certificate->setParticipationrate($participationrate);
        $this->emanager->persist($certificate);
        $this->emanager->flush();
    }

    private function insertMockDocument($name, $path, $doctypeID, $certificateID) {
        $document = new Document();
        $certificate = $this->emanager->find(Certificate::class, $certificateID);
        $doctype = $this->emanager->find(DocumentType::class, $doctypeID);
        $data = [
            'xname' => $name,
            'xpath' => $path,
            'documenttype' => $doctype,
            'certificate' => $certificate,
            'active' => true,
        ];
        $document->exchangeArray($data);
        $this->emanager->persist($document);
        $this->emanager->flush();
    }

    private function insertMockPrice($certificateID, $price, $updated_at) {
        $priceH = new PriceHistory();
        $certificate = $this->emanager->find(Certificate::class, $certificateID);
        $data = [
            'price' => $price,
            'updated_at' => $updated_at,
            'certificate' => $certificate,
        ];
        $priceH->exchangeArray($data);
        $this->emanager->persist($priceH);
        $this->emanager->flush();
    }

}
