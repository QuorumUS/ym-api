<?php

namespace P2A\YourMembership\Core;

use GuzzleHttp\Psr7\Request as GuzzleRequest;


class Request
{

    /**
     * Base URL
     * @var string
     */
    const BASE_URL = 'https://api.yourmembership.com';
    const API_VERSION = '2.25';

    private static $sessionId;
    /**
     * Call Counter for Your Membership for a given session
     * @var integer
     */
    public static $callId = 0;

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
     * @return \SimpleXMLElement  XML Envelope with necessary credential parameters
     */
    public function buildBasePayload() : \SimpleXMLElement
    {
        /*
            <YourMembership>
            <Version>2.25</Version>
            <ApiKey>3D638C5F-CCE2-4638-A2C1-355FA7BBC917</ApiKey>
            <CallID>001</CallID>
            <SaPasscode>************</SaPasscode>
            </YourMembership>
        */
        $xml = new \SimpleXMLElement('<YourMembership></YourMembership>');
        $xml->addChild('Version', self::API_VERSION);
        $xml->addChild('ApiKey', $this->apiKey);
        $xml->addChild('CallID', self::$callId);
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
        //Create Call Node
        $call = new \SimpleXMLElement('<Call> </Call>');
        $call->addAttribute('Method', $method);

        //Add Arguments to the Call Node
        foreach ($arguments as $key => $value) {
            $call->addChild($key, $value);
        }

        return $call;
    }
    /**
     * Builds The XML Request Body for the Your Membership API Call
     * @method buildXMLBody
     * @author PA
     * @date   2017-01-10
     * @param  string            $method    Your Membership API Function Name
     * @param  array             $arguments Your Membership Arguments
     * @return \SimpleXMLElement
     */
    public function buildXMLBody(string $method, array $arguments) : \SimpleXMLElement
    {
        $xml = $this->buildBasePayload(); // Common Envelope

        if ($this->isSessionRequiredForMethod($method)) {
            $xml = $this->addSessionIdToRequest($xml);
        }

        $callPayload = $this->createCallPayload($method, $arguments); // Specific API Call Envelope

        // Put Api call into common envelope
        $this->sxmlAppend($xml, $callPayload);

        return $xml;
    }

    public function buildRequest(string $method, array $arguments) : GuzzleRequest
    {
        $requestBody = $this->buildXMLBody($method, $arguments)->asXML();
        codecept_debug($requestBody);
        return new GuzzleRequest('POST', self::BASE_URL, ['Content-Type' => 'application/x-www-form-urlencoded; charset=UTF8'], $requestBody);
    }

    /**
     * Checks if Request Requires Session ID
     * @method isSessionRequiredForMethod
     * @author PA
     * @date   2017-01-10
     * @param  string                     $method YourMembership API Method
     * @return bool
     */
    public function isSessionRequiredForMethod(string $method) : bool
    {
        return ($method != 'Session.Create');
    }

    /**
     * Setter Method for SessionID
     * @method setSessionId
     * @author PA
     * @date   2017-01-10
     * @param  string       $sessionId [description]
     */
    public static function setSessionId(string $sessionId)
    {
        self::$sessionId = $sessionId;
    }

    /**
     * Helper for Deep Copy for of $from element into $to element for SimpleXML
     * @method sxmlAppend
     * @author PA
     * @date   2017-01-09
     * @param  \SimpleXMLElement $to
     * @param  \SimpleXMLElement $from
     * @return void
     */
    private function sxmlAppend(\SimpleXMLElement $to, \SimpleXMLElement $from) {
        $toDom = dom_import_simplexml($to);
        $fromDom = dom_import_simplexml($from);
        $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
    }

    /**
     * Adds the Session Variable to the given XML Request Payload
     * @method addSessionIdToRequest
     * @author PA
     * @date   2017-01-10
     * @param  \SimpleXMLElement                $requestXML Base Request XML Payload
     */
    private function addSessionIdToRequest(\SimpleXMLElement $requestXML) : \SimpleXMLElement
    {
        $requestXML->addChild('SessionID', self::$sessionId);
        return $requestXML;
    }

    public function isSessionActive()
    {
        return self::$sessionID;
    }

};
