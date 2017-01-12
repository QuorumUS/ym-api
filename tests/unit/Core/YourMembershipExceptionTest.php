<?php
namespace Core;

use P2A\YourMembership\Exceptions\YourMembershipApiException;

class YourMembershipApiExceptionTest extends \Codeception\Test\Unit
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
        $exception = new YourMembershipApiException('Message', 999, 'TestMethod');

        //verify
        echo $exception;
    }
}
