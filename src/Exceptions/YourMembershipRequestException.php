<?php
namespace P2A\YourMembership\Exceptions;

/**
 * This is an exception that is thrown when an error occurs with the API responses.
 */
class YourMembershipRequestException extends YourMembershipException
{

	/**
	 * Arguments used for the Request
	 * @var array
	 */
	private $arguments;

	/**
	 * Api Method That is related to this exception
	 * @var string
	 */
	private $apiMethod;

	public function __construct(string $message, int $code = 0, string $apiMethod, array $arguments, \Exception $e = null)
	{
		$this->apiMethod = $apiMethod;
		$this->arguments = $arguments;
		parent::__construct($message, $code, $e);
	}

	/**
	 * Returns the arguments for API Request
	 * @method getArguments
	 * @author PA
	 * @date   2017-01-12
	 * @return array
	 */

	public function getArguments() : array
	{
		return $this->arguments;
	}

	/**
	 * Returns the arguments for API Request
	 * @method getArguments
	 * @author PA
	 * @date   2017-01-12
	 * @return array
	 */

	public function getApiMethodName() : string
	{
		return $this->apiMethod;
	}

}
