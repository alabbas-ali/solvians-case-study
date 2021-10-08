<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 * @author Alabbas
 */

namespace MarketTest\Model;

use Market\Model\Market;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit_Framework_TestCase as TestCase;

class MarketTableTest extends TestCase {

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

    public function testFetchAllReturnsAllMarkets() {

        $this->manager->expects($this->once())
                ->method('getRepository')
                ->with(Market::class)
                ->will($this->returnValue($this->repository));
        $this->repository->expects($this->once())
                ->method('findAll')
                ->will($this->returnValue([]));

        $this->assertSame([], $this->manager->getRepository(Market::class)->findAll());
    }

    public function testFetchByIDMarkets() {        
        $market = $this->createMock(Market::class);
        
        $this->manager->expects($this->once())
                ->method('getRepository')
                ->with(Market::class)
                ->will($this->returnValue($this->repository));
        
        $this->repository->expects($this->once())
                ->method('findBy')
                ->with(['id' => 1])
                ->will($this->returnValue($market));
        
        $result = $this->manager
                ->getRepository('Market\Model\Market')
                ->findBy(['id' => 1]);
        
        //$this->assertCount(1, $result);
        $this->assertInstanceOf('Market\Model\Market', $result);
    }
    
    /**
     * there are many ather test cases can be implemented here ...
     * 
     */

}
