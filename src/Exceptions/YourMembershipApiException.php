<?php
namespace P2A\YourMembership\Exceptions;

/**
 * This is an exception that is thrown when an error occurs with the API responses.
 */
class YourMembershipApiException extends YourMembershipException
{
	private $apiMethod;

	public function __construct(string $message, int $code = 0, string $apiMethod, \Exception $e = null)
	{
		$this->apiMethod = $apiMethod;
		parent::__construct($message, $code, $e);
	}

	public function __toString()
	{
	   return __CLASS__ . ": [{$this->apiMethod}]: {$this->message}\n";
   }

}
