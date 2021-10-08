<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IssuerTest
 *
 * @author Alabbas
 */

namespace IssuerTest\Model;

use Issuer\Model\Issuer;
use PHPUnit_Framework_TestCase as TestCase;

class IssuerTest extends TestCase {

    public function testInitialIssuerValuesAreNull() {
        $issuer = new Issuer();

        $this->assertNull($issuer->xname, '"xname" should be null by default');
        $this->assertNull($issuer->id, '"id" should be null by default');
        $this->assertNull($issuer->active, '"active" should be null by default');
    }

    public function testExchangeArraySetsPropertiesCorrectly() {
        $issuer = new Issuer();
        $data = [
            'xname' => 'XXXXXX',
            'id' => 123,
            'active' => true
        ];

        $issuer->exchangeArray($data);

        $this->assertSame(
                $data['xname'], $issuer->xname, '"xname" was not set correctly'
        );

        $this->assertSame(
                $data['id'], $issuer->id, '"id" was not set correctly'
        );

        $this->assertSame(
                $data['active'], $issuer->active, '"active" was not set correctly'
        );
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent() {
        $issuer = new Issuer();

        $issuer->exchangeArray([
            'xname' => 'XXXXXX',
            'id' => 123,
            'active' => true
        ]);

        $issuer->exchangeArray([]);

        $this->assertNull($issuer->xname, '"xname" should default to null');
        $this->assertNull($issuer->id, '"id" should default to null');
        $this->assertNull($issuer->active, '"active" should default to null');
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues() {
        $issuer = new Issuer();
        $data = [
            'xname' => 'XXXXXX',
            'id' => 123,
            'active' => true
        ];

        $issuer->exchangeArray($data);
        $copyArray = $issuer->getArrayCopy();

        $this->assertSame($data['xname'], $copyArray['xname'], '"xname" was not set correctly');
        $this->assertSame($data['id'], $copyArray['id'], '"id" was not set correctly');
        $this->assertSame($data['active'], $copyArray['active'], '"active" was not set correctly');
    }

    public function testInputFiltersAreSetCorrectly() {
        $issuer = new Issuer();

        $inputFilter = $issuer->getInputFilter();

        $this->assertSame(2, $inputFilter->count());
        $this->assertTrue($inputFilter->has('xname'));
        $this->assertTrue($inputFilter->has('id'));
    }

}
