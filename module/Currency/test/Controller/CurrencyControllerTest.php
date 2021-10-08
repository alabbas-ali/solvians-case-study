<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CurrencyTest\Controller;

use Currency\Controller\CurrencyController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Description of CurrencyControllerTest
 *
 * @author Alabbas
 */
class CurrencyControllerTest extends AbstractHttpControllerTestCase {

    protected $traceError = true;

    public function setUp() {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
                        include __DIR__ . '/../../../../config/application.config.php', $configOverrides
        ));

        parent::setUp();
    }

    public function testIndexActionCanBeAccessed() {
        $this->dispatch('/currency');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Currency');
        $this->assertControllerName(CurrencyController::class);
        // as specified in router's controller name alias
        $this->assertControllerClass('CurrencyController');
        $this->assertMatchedRouteName('currency');
    }

    public function testIndexActionViewModelTemplateRenderedWithinLayout() {
        $this->dispatch('/', 'GET');
        $this->assertQuery('.container .jumbotron');
    }

    public function testInvalidRouteDoesNotCrash() {
        $this->dispatch('/invalid/route', 'GET');
        $this->assertResponseStatusCode(404);
    }

    public function testAddActionRedirectsAfterValidPost() {
        /* $this->albumTable->saveAlbum(Argument::type(Album::class))
          ->shouldBeCalled(); */

        $postData = [
            'xname' => 'XXXX',
            'code' => 'USD',
            'symbol' => '$',
            'id' => ''
        ];
        $this->dispatch('/currency/add', 'POST', $postData);
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/currency');
    }

}
