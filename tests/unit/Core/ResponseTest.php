<?php
namespace Core;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

use P2A\YourMembership\Core\Response;
use P2A\YourMembership\Exceptions\YourMembershipApiException;

class ResponseTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private $errorResponseXML = <<<'EOD'
<?xml version="1.0" encoding="utf-8" ?>
<YourMembership_Response>
<ErrCode>403</ErrCode>
<ErrDesc>Method requires authentication.</ErrDesc>
<XmlRequest>
<YourMembership>
<Version>2.25</Version>
<ApiKey>3D638C5F-CCE2-4638-A2C1-355FA7BBC917</ApiKey>
<CallID>001</CallID>
<SessionID>A07C3BCC-0B39-4977-9E64-C00E918D572E</SessionID>
<Call Method="Member.Profile.Get"></Call>
</YourMembership>
</XmlRequest>
</YourMembership_Response>
EOD;

private $goodResponseXML = <<<'EOD'
<?xml version="1.0" encoding="utf-8" ?>

<YourMembership_Response>
<ErrCode>0</ErrCode>
<People.All.Search>
<Results ResultTotal="12">
<Item>
<ProfileID>5846548</ProfileID>
<PrimaryGroupName>Class Year: 1998</PrimaryGroupName>
<IsMember>1</IsMember>
<IsNonMember>0</IsNonMember>
<Name>Elizabeth M. Allen</Name>
<City></City>
<Location></Location>
</Item>
<Item>
<ProfileID>718978</ProfileID>
<PrimaryGroupName>Class Year: 1983</PrimaryGroupName>
<IsMember>0</IsMember>
<IsNonMember>1</IsNonMember>
<Name>Lansing Allen</Name>
<City>FLORISSANT</City>
<Location>Missouri</Location>
<Lost>0</Lost>
<Deceased>0</Deceased>
<Comments></Comments>
</Item>
</Results>
</People.All.Search>
</YourMembership_Response>
EOD;

    protected function _before()
    {
    }

    protected function _after()
    {
    }


    private function makeResponse($method, $xml)
    {
        $guzzleResponse = new GuzzleResponse(200, ['X-Foo' => 'Bar'], $xml);
        return new Response($method, $guzzleResponse);
    }
    // tests
    public function testHasError()
    {
        //Setup
        $response = $this->makeResponse('Member.Profile.Get', $this->errorResponseXML);

        //Verify
        $this->assertTrue($response->hasError());
    }

    public function testGetErrorCode()
    {
        //Setup
        $response = $this->makeResponse('Member.Profile.Get', $this->errorResponseXML);

        //Verify
        $this->assertEquals(403, $response->getErrorCode());
    }

    public function testGetError()
    {
        //Setup
        $response = $this->makeResponse('Member.Profile.Get', $this->errorResponseXML);

        //Verify
        $this->assertEquals('Method requires authentication.', $response->getError());
    }

    public function testToArrayWithError() {
        //Setup
        $response = $this->makeResponse('Member.Profile.Get', $this->errorResponseXML);

        //Execute and Verify
        $this->tester->expectException(YourMembershipApiException::class, function() use ($response)
        {
            $a = $response->toArray();
        });
    }
    public function testToArray()
    {
        //Setup
        $response = $this->makeResponse('People.All.Search',$this->goodResponseXML);

        //Execute
        $array = $response->toArray();

        //Verify
        $this->assertTrue(is_array($array));
    }

    public function testToObject()
    {
        //Setup
        $response = $this->makeResponse('People.All.Search',$this->goodResponseXML);

        //Execute
        $object = $response->toObject();

        //Verify
        $this->assertTrue(is_object($object));
    }

    public function testGetResultCount()
    {
        //Setup
        $response = $this->makeResponse('People.All.Search',$this->goodResponseXML);

        //Execute
        $count = $response->getResultCount();

        //Verify
        $this->assertEquals(12,$count);
    }


}
