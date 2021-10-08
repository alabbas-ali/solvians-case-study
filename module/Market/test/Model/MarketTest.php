<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MarketTest
 *
 * @author Alabbas
 */

namespace MarketTest\Model;

use Market\Model\Market;
use PHPUnit_Framework_TestCase as TestCase;

class MarketTest extends TestCase {

    public function testInitialMarketValuesAreNull() {
        $market = new Market();
        
        $this->assertNull($market->id, '"id" should be null by default');
        $this->assertNull($market->xname, '"xname" should be null by default');
        $this->assertNull($market->active, '"active" should be null by default');
    }

    public function testExchangeArraySetsPropertiesCorrectly() {
        $market = new Market();
        $data = [
            'id' => 12,
            'xname' => 'XXXXXX',
            'active' => true
        ];

        $market->exchangeArray($data);

        $this->assertSame(
                $data['xname'], $market->xname, '"xname" was not set correctly'
        );

        $this->assertSame(
                $data['id'], $market->id, '"id" was not set correctly'
        );
        
        $this->assertSame(
                $data['active'], $market->active, '"active" was not set correctly'
        );
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent() {
        $market = new Market();

        $market->exchangeArray([
            'id' => 12,
            'xname' => 'XXXXXX',
            'active' => true
        ]);
        
        $market->exchangeArray([]);

        $this->assertNull($market->xname, '"xname" should default to null');
        $this->assertNull($market->id, '"id" should default to null');
        $this->assertNull($market->active, '"active" should default to null');
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues() {
        $market = new Market();
        $data = [
            'id' => 12,
            'xname' => 'XXXXXX',
            'active' => true
        ];

        $market->exchangeArray($data);
        $copyArray = $market->getArrayCopy();

        $this->assertSame($data['xname'], $copyArray['xname'], '"xname" was not set correctly');
        $this->assertSame($data['id'], $copyArray['id'], '"id" was not set correctly');
        $this->assertSame($data['active'], $copyArray['active'], '"active" was not set correctly');
    }

    public function testInputFiltersAreSetCorrectly() {
        $market = new Market();

        $inputFilter = $market->getInputFilter();

        $this->assertSame(2, $inputFilter->count());
        $this->assertTrue($inputFilter->has('xname'));
        $this->assertTrue($inputFilter->has('id'));
    }

}
