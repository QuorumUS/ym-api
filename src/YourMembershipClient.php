<?php

namespace P2A\YourMembership;

use GuzzleHttp\Client;
use P2A\YourMembership\Core\Request;
use P2A\YourMembership\Core\Response;

class YourMembershipClient
{

    /**
     * Guzzle Client
     * @var \GuzzleHttp\Client
     */
    private $client;
    /**
     * YourMembership Request
     * @var Request
     */
    private $request;

    public function __construct(Client $client, string $apiKey, string $saPasscode)
    {
        $this->client = $client;
        $this->request = new Request($apiKey, $saPasscode);
        $sessionID = $this->createSession();
        Request::setSessionID($sessionID);

    }
    /**
     * Makes API Call to YourMembership
     * @method makeCall
     * @author PA
     * @date   2017-01-10
     * @param  string     $method    Your Membership API Method
     * @param  array      $arguments  Your Membership API Call Arguments
     * @return Response
     */
    public function makeCall(string $method, array $arguments = [])
    {

        Request::$callId++; //Update the Call ID as they need to be unique per call
        $request = $this->request->buildRequest($method, $arguments);

        $response = $this->client->send($request);

        return new Response($method, $response);
    }

    /**
     * Creates a new Session with YourMembership
     * @method createSession
     * @author PA
     * @date   2017-01-10
     * @return string        SessionID
     */
    private function createSession() : string
    {
        $response = $this->makeCall('Session.Create')->toObject();
        return $response->SessionID;

    }

}
