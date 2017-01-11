<?php
namespace Core;
use P2A\YourMembership\Core\Request;

class RequestTest extends \Codeception\Test\Unit
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


    public function testBuildBasePayload() {

        $apiKey = 'A';
        $saPasscode  ='B';
        $callId = '0';
        $request = new Request($apiKey, $saPasscode);

        $xml =  $request->buildBasePayload();

        $this->assertEquals(Request::API_VERSION, $xml->Version, 'Versions Do Not Match');
        $this->assertEquals($apiKey, $xml->ApiKey, 'API Key Does not Match');
        $this->assertEquals($saPasscode, $xml->SaPasscode,'Sa Passcode Does not match');
        $this->assertEquals($callId, (string) $xml->CallID, 'Call ID does not match');

        codecept_debug($xml->asXML());
    }


    public function testCreateCallPayLoad()
    {
        //Setup
        $apiKey = 'A';
        $saPasscode  ='B';
        $method = 'testMethod';
        $arguments = ['arg1' => 'value1', 'arg2' => 'value2'];
        $request = new Request($apiKey, $saPasscode);
        //Execute
        $xml = $request->createCallPayload($method, $arguments);

        $attributes = $xml->attributes();

        //Verify Method Signature
        $this->assertNotEmpty($attributes['Method'], 'Call Method Incorrect');
        $this->assertEquals($method, $attributes['Method'], 'Call Method Incorrect');

        $children = $xml->children();
        //Verify Method Arguments
        //Invert Children and Arguments because Children is not Array Iterable...
        foreach ($children as $key => $value) {
                $this->assertArrayHasKey($key, $arguments, 'Argument Does Not Exist');
                $this->assertEquals($value, $arguments[$key], 'Invalid Argument');
        }

        codecept_debug($xml->asXML());
    }

    public function testBuildXMLBody() {

        $apiKey = 'A';
        $saPasscode  ='B';
        $callId = '0';
        $method = 'testMethod';
        $arguments = ['arg1' => 'value1', 'arg2' => 'value2'];
        $request = new Request($apiKey, $saPasscode);

        $xml = $request->buildXMLBody($method, $arguments);
        codecept_debug($xml->asXML());
        //Verify
        $this->assertEquals(Request::API_VERSION, $xml->Version, 'Versions Do Not Match');
        $this->assertEquals($apiKey, $xml->ApiKey, 'API Key Does not Match');
        $this->assertEquals($saPasscode, $xml->SaPasscode,'Sa Passcode Does not match');
        $this->assertEquals($callId, $xml->CallID, 'Call ID does not match');


        $attributes = $xml->Call->attributes();

        //Verify Method Signature
        $this->assertNotEmpty($attributes['Method'], 'Call Method Incorrect');
        $this->assertEquals($method, $attributes['Method'], 'Call Method Incorrect');

        $children = $xml->Call->children();
        //Verify Method Arguments
        //Invert Children and Arguments because Children is not Array Iterable...
        foreach ($children as $key => $value) {
                $this->assertArrayHasKey($key, $arguments, 'Argument Does Not Exist');
                $this->assertEquals($value, $arguments[$key], 'Invalid Argument');
        }

        codecept_debug($xml->asXML());
    }

    public function testBuildRequest()
    {
        $apiKey = 'A';
        $saPasscode  ='B';
        $callId = '0';
        $method = 'testMethod';
        $arguments = ['arg1' => 'value1', 'arg2' => 'value2'];
        $request = new Request($apiKey, $saPasscode);

        $request->buildXMLBody($method,$arguments);

        $request = $request->buildRequest($method,$arguments);

        $this->assertInstanceOf(\GuzzleHttp\Psr7\Request::class, $request);

    }

    public function testHasSession()
    {
        $this->assertFalse(Request::hasSession());
        Request::setSessionId('A');
        $this->assertTrue(Request::hasSession());

    }

}
