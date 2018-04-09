<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FormLocationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FormLocationsTable Test Case
 */
class FormLocationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FormLocationsTable
     */
    public $FormLocations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.form_locations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('FormLocations') ? [] : ['className' => 'App\Model\Table\FormLocationsTable'];
        $this->FormLocations = TableRegistry::get('FormLocations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FormLocations);

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
