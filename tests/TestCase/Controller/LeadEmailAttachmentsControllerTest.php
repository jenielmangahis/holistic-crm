<?php
namespace App\Test\TestCase\Controller;

use App\Controller\LeadEmailAttachmentsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\LeadEmailAttachmentsController Test Case
 */
class LeadEmailAttachmentsControllerTest extends IntegrationTestCase
{

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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
