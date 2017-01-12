<?php
namespace Core;

use P2A\YourMembership\Exceptions\YourMembershipRequestException;

class YourMembershipRequestExceptionTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        require_once(__DIR__ . '/../../../vendor/autoload.php'); // Autoload files using Composer autoload
    }

    protected function _after()
    {
    }

    // tests
    public function testGetArguments()
    {
        $method = 'testMethod';
        $arguments = ['arg1', 'arg2'];
        $exception  = new YourMembershipRequestException('A', 1, $method, $arguments);

        $this->assertEquals($arguments, $exception->getArguments());
    }

    public function testGetApiMethod()
    {
        $method = 'testMethod';
        $arguments = ['arg1', 'arg2'];
        $exception  = new YourMembershipRequestException('A', 1, $method, $arguments);

        $this->assertEquals($method, $exception->getApiMethodName());
    }
}
