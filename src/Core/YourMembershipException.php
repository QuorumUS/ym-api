<?php


namespace P2A\YourMembership\Core;


/**
 *
 */
class YourMembershipException extends \Exception
{
	private $apiMethod;

	public function __construct(string $message, int $code = 0, string $apiMethod)
	{
		$this->apiMethod = $apiMethod;
		parent::__construct($message, $code, null);
	}

	public function __toString()
	{
	   return __CLASS__ . ": [{$this->apiMethod}]: {$this->message}\n";
   }

}
