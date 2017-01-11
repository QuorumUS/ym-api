<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response as GuzzleResponse;


use P2A\YourMembership\YourMembershipClient;

class YourMembershipClientTest extends \Codeception\Test\Unit
{

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

private $goodSessionResponse = <<<'EOD'
<?xml version="1.0" encoding="utf-8" ?>
<YourMembership_Response>
<ErrCode>0</ErrCode>
<Session.Create>
<SessionID>A07C3BCC-0B39-4977-9E64-C00E918D572E</SessionID>
</Session.Create>
</YourMembership_Response>
EOD;
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        require_once (__DIR__ . '/../../vendor/autoload.php'); // Autoload files using Composer autoload
    }

    protected function _after()
    {
    }

    // tests
    public function testMakeCall()
    {
        // Mock the Guzzle Client
        $mock = new MockHandler([
             new GuzzleResponse(200, ['X-Foo' => 'Bar'] , $this->goodSessionResponse),
             new GuzzleResponse(200, ['X-Foo' => 'Bar'] , $this->goodResponseXML)
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $yourMembershipClient = new YourMembershipClient($client, 'a', 'b');

        $response = $yourMembershipClient->makeCall('a', []);

        $parsedResponse = $response->toObject();
    }


}
