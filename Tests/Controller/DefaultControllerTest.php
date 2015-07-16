<?php

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TMSolution\LoggingBundle\Tests\Controller;

use TMSolution\TestingBundle\Functional\AppTestCase;
use TMSolution\TestingBundle\Functional\Url;

/**
 * Functional test for TMSolution\LoggingBundle\Controller\DefaultController 
 */
class DefaultControllerTest extends AppTestCase
{
    /**
     * Function test for TMSolution\LoggingBundle\Controller\DefaultController::readChannelAppAction
     *
     * @Url("/panel/log/app/lista")
     */
    public function testReadChannelAppAction()
    {
        $this->assertTrue(true);
    }
    
    /**
     * Function test for TMSolution\LoggingBundle\Controller\DefaultController::readChannelEdiAction
     *
     * @Url("/panel/log/edilog/lista")
     */
    public function testReadChannelEdiAction()
    {
        $this->assertTrue(true);
    }
    
    /**
     * Function test for TMSolution\LoggingBundle\Controller\DefaultController::indexAction
     *
     * @Url("")
     */
    public function testIndexAction()
    {
        $this->assertTrue(true);
    }
    
    /**
     * Function test for TMSolution\LoggingBundle\Controller\DefaultController::newAction
     *
     * @Url("")
     */
    public function testNewAction()
    {
        $this->assertTrue(true);
    }
    
}
