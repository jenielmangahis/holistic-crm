<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InterestTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InterestTypesTable Test Case
 */
class InterestTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InterestTypesTable
     */
    public $InterestTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.interest_types',
        'app.leads',
        'app.statuses',
        'app.sources',
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
        $config = TableRegistry::exists('InterestTypes') ? [] : ['className' => 'App\Model\Table\InterestTypesTable'];
        $this->InterestTypes = TableRegistry::get('InterestTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InterestTypes);

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
