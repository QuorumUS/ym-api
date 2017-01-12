<?php
namespace Core;

use P2A\YourMembership\Exceptions\YourMembershipResponseException;

class YourMembershipResponseExceptionTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        require_once (__DIR__ . '/../../../vendor/autoload.php'); // Autoload files using Composer autoload
    }

    protected function _after()
    {
    }

    // tests
    public function testToString()
    {
        //setup
        $exception = new YourMembershipResponseException('Message', 999, 'TestMethod');

        //verify        
        $this->assertEquals((string) $exception, YourMembershipResponseException::class.": [TestMethod]: Message\n") ;
    }

    public function testGetApiMethodName()
    {
        $method = 'testMethod';
        $arguments = ['arg1', 'arg2'];
        $exception  = new YourMembershipResponseException('A', 1, $method);

        $this->assertEquals($method, $exception->getApiMethodName());
    }
}
