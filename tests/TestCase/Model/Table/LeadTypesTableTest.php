<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LeadTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LeadTypesTable Test Case
 */
class LeadTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LeadTypesTable
     */
    public $LeadTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.lead_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LeadTypes') ? [] : ['className' => 'App\Model\Table\LeadTypesTable'];
        $this->LeadTypes = TableRegistry::get('LeadTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LeadTypes);

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
