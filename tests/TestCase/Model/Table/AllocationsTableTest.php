<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AllocationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AllocationsTable Test Case
 */
class AllocationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AllocationsTable
     */
    public $Allocations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.allocations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Allocations') ? [] : ['className' => 'App\Model\Table\AllocationsTable'];
        $this->Allocations = TableRegistry::get('Allocations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Allocations);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
