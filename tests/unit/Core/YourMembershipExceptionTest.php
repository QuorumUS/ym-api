<?php
namespace Core;

use P2A\YourMembership\Core\YourMembershipException;

class YourMembershipExceptionTest extends \Codeception\Test\Unit
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
        $exception = new YourMembershipException('Message', 999, 'TestMethod');

        echo $exception;
    }
}
