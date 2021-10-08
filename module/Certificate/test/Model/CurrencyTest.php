<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CurrencyTest
 *
 * @author Alabbas
 */

namespace CurrencyTest\Model;

use Currency\Model\Currency;
use PHPUnit_Framework_TestCase as TestCase;

class CurrencyTest extends TestCase {

    public function testInitialCurrencyValuesAreNull() {
        $currency = new Currency();

        $this->assertNull($currency->xname, '"xname" should be null by default');
        $this->assertNull($currency->id, '"id" should be null by default');
        $this->assertNull($currency->code, '"code" should be null by default');
        $this->assertNull($currency->symbol, '"symbol" should be null by default');
        $this->assertNull($currency->active, '"active" should be null by default');
    }

    public function testExchangeArraySetsPropertiesCorrectly() {
        $currency = new Currency();
        $data = [
            'xname' => 'XXXXXX',
            'id' => 123,
            'code' => 'XXX',
            'symbol' => '$',
            'active' => true
        ];

        $currency->exchangeArray($data);

        $this->assertSame(
                $data['xname'], $currency->xname, '"xname" was not set correctly'
        );

        $this->assertSame(
                $data['id'], $currency->id, '"id" was not set correctly'
        );

        $this->assertSame(
                $data['code'], $currency->code, '"code" was not set correctly'
        );

        $this->assertSame(
                $data['symbol'], $currency->symbol, '"symbol" was not set correctly'
        );
        
        $this->assertSame(
                $data['active'], $currency->active, '"active" was not set correctly'
        );
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent() {
        $currency = new Currency();

        $currency->exchangeArray([
            'xname' => 'XXXXXX',
            'id' => 123,
            'code' => 'XXX',
            'symbol' => '$',
            'active' => true
        ]);
        
        $currency->exchangeArray([]);

        $this->assertNull($currency->xname, '"xname" should default to null');
        $this->assertNull($currency->id, '"id" should default to null');
        $this->assertNull($currency->code, '"code" should default to null');
        $this->assertNull($currency->symbol, '"symbol" should default to null');
        $this->assertNull($currency->active, '"active" should default to null');
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues() {
        $currency = new Currency();
        $data = [
            'xname' => 'XXXXXX',
            'id' => 123,
            'code' => 'XXX',
            'symbol' => '$',
            'active' => true
        ];

        $currency->exchangeArray($data);
        $copyArray = $currency->getArrayCopy();

        $this->assertSame($data['xname'], $copyArray['xname'], '"xname" was not set correctly');
        $this->assertSame($data['id'], $copyArray['id'], '"id" was not set correctly');
        $this->assertSame($data['code'], $copyArray['code'], '"code" was not set correctly');
        $this->assertSame($data['symbol'], $copyArray['symbol'], '"code" was not set correctly');
        $this->assertSame($data['active'], $copyArray['active'], '"active" was not set correctly');
    }

    public function testInputFiltersAreSetCorrectly() {
        $currency = new Currency();

        $inputFilter = $currency->getInputFilter();

        $this->assertSame(4, $inputFilter->count());
        $this->assertTrue($inputFilter->has('xname'));
        $this->assertTrue($inputFilter->has('id'));
        $this->assertTrue($inputFilter->has('code'));
        $this->assertTrue($inputFilter->has('symbol'));
    }

}
