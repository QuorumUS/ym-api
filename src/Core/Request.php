<?php

namespace P2A\YourMembership\Core;

/**
 *
 */
class Request
{

    public static $API_VERSION = '2.25';
    public static $BASE_URL = 'https://api.yourmembership.com';

    public static $callID = 1;

    private $apiKey;
    private $saPasscode;
    private $version;


    function __construct(string $apiKey, string $saPasscode)
    {
        $this->apiKey = $apiKey;
        $this->saPasscode = $saPasscode;
    }

    /**
     * Create the Base Envelope for an API call to YourMembership
     * @method buildBasePayload
     * @author PA
     * @date   2017-01-09
     * @return SimpleXMLElement  XML Envelope with necessary credential parameters
     */
    public function buildBasePayload() : \SimpleXMLElement
    {
        /*
            <YourMembership>
            <Version>2.25</Version>
            <ApiKey>3D638C5F-CCE2-4638-A2C1-355FA7BBC917</ApiKey>
            <CallID>001</CallID>
            <SaPasscode>************</SaPasscode>
            <Call Method="Sa.People.Profile.Get">
                <ID>8D88D43A-B15B-4041-BEA0-89B05B2D9540</ID>
            </Call>
            </YourMembership>
    */

        $xml = new \SimpleXMLElement('<YourMembership></YourMembership>');
        $xml->addChild('Version', self::$API_VERSION);
        $xml->addChild('ApiKey', $this->apiKey);
        $xml->addChild('CallID', self::$callID);
        $xml->addChild('SaPasscode', $this->saPasscode);

        return $xml;
    }

    /**
     * Generates the XML for a API method call within
     * @method createCallPayload
     * @author PA
     * @date   2017-01-09
     * @param  string            $method    YourMembership API Function Name
     * @param  array             $arguments Array of Arguments to be passed as part of the YourMembership "Call"
     * @return \SimpleXMLElement
     */
    public function createCallPayload(string $method, array $arguments) : \SimpleXMLElement
    {

        $call = new \SimpleXMLElement('<Call></Call>');
        $call->addAttribute('method',$method);

        foreach ($arguments as $key => $value) {
            $call->addChild($key,$value);
        }

        return $call;
    }

    public function buildXMLPayload(string $method, array $arguments) : \SimpleXMLElement
    {
        $xml = $this->buildBasePayload();
        $callPayload = $this->createCallPayload($method,$arguments);

        $this->sxmlAppend($xml,$callPayload);

        return $xml;
    }
    /**
     * Complete XML envelope
     * @method call
     * @author PA
     * @date   2017-01-09
     * @param  string     $method    [description]
     * @param  array      $arguments [description]
     * @return [type]                [description]
     */
    public function call(string $method, array $arguments) {

        $xml = $this->buildXMLPayload($method, $arguments);

        self::$callId++; //Update the Call ID as they need to be unique per call

        return $xml;
    }
    /**
     * Deep Copy for SimpleXML
     * @method sxmlAppend
     * @author PA
     * @date   2017-01-09
     * @param  SimpleXMLElement $to
     * @param  SimpleXMLElement $from
     */
    private function sxmlAppend(\SimpleXMLElement $to, \SimpleXMLElement $from)  {
        $toDom = dom_import_simplexml($to);
        $fromDom = dom_import_simplexml($from);
        $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
    }

};
