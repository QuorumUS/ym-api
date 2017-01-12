<?php
namespace P2A\YourMembership\Exceptions;

/**
 * This is an exception that is thrown when an error occurs with the API responses.
 */
class YourMembershipResponseException extends YourMembershipException
{
	/**
	 * Api Method That is related to this exception
	 * @var string
	 */
	private $apiMethod;

	public function __construct(string $message, int $code = 0, string $apiMethod, \Exception $e = null)
	{
		$this->apiMethod = $apiMethod;
		parent::__construct($message, $code, $e);
	}

	/**
	 * Returns the APi Method Name
	 * @method getApiMethodName
	 * @author PA
	 * @date   2017-01-12
	 * @return string
	 */
	public function getApiMethodName() : string {
		return $this->apiMethod;
	}

	public function __toString()
	{
	   return __CLASS__ . ": [{$this->apiMethod}]: {$this->message}\n";
    }

}
