<?php

namespace P2A\YourMembership;

use GuzzleHttp\Client;
use P2A\YourMembership\Core\Request;
use P2A\YourMembership\Core\Response;
use P2A\YourMembership\Exceptions\YourMembershipResponseException;

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
	 * @author AB http://github.com/chefboyarsky
	 * @date   2017-01-10
	 * @param  string     $method    Your Membership API Method
	 * @param  array      $arguments  Your Membership API Call Arguments
	 * @return Response
	 * @throws YourMembershipResponseException If the response from the API has an error
	 */
	public function makeCall(string $method, array $arguments = [])
	{

		Request::$callId++; //Update the Call ID as they need to be unique per call
		$request = $this->request->buildRequest($method, $arguments);

		$response = new Response($method, $this->client->send($request));

		if($response->hasError())
		{
			throw new YourMembershipResponseException($response->getError(), $response->getErrorCode(), $method);
		}

		return $response;
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
