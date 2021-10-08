<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 * @author Alabbas
 */

namespace CurrencyTest\Model;

use Currency\Model\Currency;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit_Framework_TestCase as TestCase;

class CurrencyTableTest extends TestCase {

    /**
     * @var EntityManager
     */
    private $manager;

    /**
     *
     * @var EntityRepository 
     */
    private $repository;

    public function setUp() {
        $this->manager = $this->getMockBuilder(EntityManager::class)
                ->disableOriginalConstructor()
                ->getMock();
        $this->repository = $this->getMockBuilder(EntityRepository::class)
                ->disableOriginalConstructor()
                ->getMock();
    }

    public function testFetchAllReturnsAllCurrencys() {

        $this->manager->expects($this->once())
                ->method('getRepository')
                ->with(Currency::class)
                ->will($this->returnValue($this->repository));
        $this->repository->expects($this->once())
                ->method('findAll')
                ->will($this->returnValue([]));

        $this->assertSame([], $this->manager->getRepository('Currency\Model\Currency')->findAll());
    }

    public function testFetchByIDCurrencys() {
        
        $currency = $this->createMock(Currency::class);
        
        $this->manager->expects($this->once())
                ->method('getRepository')
                ->with(Currency::class)
                ->will($this->returnValue($this->repository));
        
        $this->repository->expects($this->once())
                ->method('findBy')
                ->with(['id' => 1])
                ->will($this->returnValue($currency));
        
        $result = $this->manager
                ->getRepository('Currency\Model\Currency')
                ->findBy(['id' => 1]);
        
        //$this->assertCount(1, $result);
        $this->assertInstanceOf('Currency\Model\Currency', $result);
    }
    
    /**
     * there are many ather test cases can be implemented here ...
     * 
     */

}
