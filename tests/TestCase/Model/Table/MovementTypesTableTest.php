<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MovementTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MovementTypesTable Test Case
 */
class MovementTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MovementTypesTable
     */
    public $MovementTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.movement_types',
        'app.movements'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MovementTypes') ? [] : ['className' => 'App\Model\Table\MovementTypesTable'];
        $this->MovementTypes = TableRegistry::get('MovementTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MovementTypes);

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
