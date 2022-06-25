<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\UserComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\UserComponent Test Case
 */
class UserComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\UserComponent
     */
    protected $UserComponent;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->UserComponent = new UserComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->UserComponent);

        parent::tearDown();
    }
}
