<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MarketTest\Controller;

use Market\Controller\TradingMarketController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Description of TradingMarketControllerTest
 *
 * @author Alabbas
 */
class TradingMarketControllerTest extends AbstractHttpControllerTestCase {

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
        $this->dispatch('/market');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('market');
        $this->assertControllerName(TradingMarketController::class); // as specified in router's controller name alias
        $this->assertControllerClass('TradingMarketController');
        $this->assertMatchedRouteName('market');
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
        $postData = [
            'xname' => 'XXXX',
            'id' => ''
        ];
        $this->dispatch('/market/add', 'POST', $postData);
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/market');
    }

}
