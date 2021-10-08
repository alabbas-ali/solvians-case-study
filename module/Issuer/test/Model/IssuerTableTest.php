<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 * @author Alabbas
 */

namespace IssuerTest\Model;

use Issuer\Model\Issuer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit_Framework_TestCase as TestCase;

class IssuerTableTest extends TestCase {

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

    public function testFetchAllReturnsAllIssuers() {

        $this->manager->expects($this->once())
                ->method('getRepository')
                ->with(Issuer::class)
                ->will($this->returnValue($this->repository));
        $this->repository->expects($this->once())
                ->method('findAll')
                ->will($this->returnValue([]));

        $this->assertSame([], $this->manager->getRepository(Issuer::class)->findAll());
    }

    public function testFetchByIDIssuers() {
        
        $issuer = $this->createMock(Issuer::class);
        
        $this->manager->expects($this->once())
                ->method('getRepository')
                ->with(Issuer::class)
                ->will($this->returnValue($this->repository));
        
        $this->repository->expects($this->once())
                ->method('findBy')
                ->with(['id' => 1])
                ->will($this->returnValue($issuer));
        
        $result = $this->manager
                ->getRepository('Issuer\Model\Issuer')
                ->findBy(['id' => 1]);
        
        //$this->assertCount(1, $result);
        $this->assertInstanceOf('Issuer\Model\Issuer', $result);
    }
    
    /**
     * there are many ather test cases can be implemented here ...
     * 
     */

}
