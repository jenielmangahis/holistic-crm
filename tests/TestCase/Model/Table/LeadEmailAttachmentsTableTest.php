<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LeadEmailAttachmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LeadEmailAttachmentsTable Test Case
 */
class LeadEmailAttachmentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LeadEmailAttachmentsTable
     */
    public $LeadEmailAttachments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.lead_email_attachments',
        'app.lead_email_messages',
        'app.users',
        'app.aros',
        'app.acos',
        'app.permissions',
        'app.groups',
        'app.user_entities',
        'app.allocation_users',
        'app.allocations',
        'app.source_users',
        'app.sources',
        'app.leads',
        'app.statuses',
        'app.lead_types',
        'app.interest_types',
        'app.last_modified_by',
        'app.lead_attachments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LeadEmailAttachments') ? [] : ['className' => 'App\Model\Table\LeadEmailAttachmentsTable'];
        $this->LeadEmailAttachments = TableRegistry::get('LeadEmailAttachments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LeadEmailAttachments);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
