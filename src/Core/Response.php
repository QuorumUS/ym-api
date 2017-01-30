<?php

namespace P2A\YourMembership\Core;

use P2A\YourMembership\Exceptions\YourMembershipResponseException;
/**
 * Your Membership Response Object
 */
class Response
{
	private $method;
	private $response;

	public function __construct(string $method, $response)
	{
		$this->method = $method;

		$body = $response->getBody()->getContents();
		$this->response = new \SimpleXMLElement($body);

	}

	/**
	 * Checks if the response contains an Error
	 * @method hasError
	 * @author PA
	 * @date   2017-01-10
	 * @return bool       hasError
	 */
	public function hasError() : bool
	{
		return ($this->getErrorCode() != 0);
	}

	/**
	 * Fetches the Error Code from the Response
	 * @method getErrorCode
	 * @author PA
	 * @date   2017-01-10
	 * @return int          Error Code
	 */
	public function getErrorCode() : int
	{
		return (int) $this->response->ErrCode;
	}

	/**
	 * Fetches the Error Message From Response
	 * @method getError
	 * @author PA
	 * @date   2017-01-10
	 * @return string     Error Message
	 */
	public function getError() : string
	{
		return (string) $this->response->ErrDesc;
	}

	/**
	 * Converts the response to an Array
	 * @method toArray
	 * @throws YourMembershipResponseException
	 * @author PA
	 * @date   2017-01-10
	 * @return array      Response
	 */
	public function toArray() : array
	{
		return $this->unwrapXMLObject(true);
	}

	/**
	 * Converts the response to an Object
	 * @method toObject
	 * @throws YourMembershipResponseException
	 * @author PA
	 * @date   2017-01-11
	 * @return stdClass  Response
	 */
	public function toObject() : \stdClass
	{
		return $this->unwrapXMLObject(false);
	}

	/**
	 * Unwraps XML Object into either StdClass or Array
	 * Lossy conversion, attributes are lost from XML
	 *
	 * @method unwrapXMLObject
	 * @throws YourMembershipResponseException
	 * @author PA
	 * @date   2017-01-11
	 * @param  bool            $asArray unwrap the object into an array instead of object
	 * @return mixed|null      Unwrapped Response
	 */
	private function unwrapXMLObject(bool $asArray)
	{
		//We cannot unwrap objects that have errors, so throw an exception
		if ($this->hasError()) {
			throw new YourMembershipResponseException($this->getError(), $this->getErrorCode(), $this->method);
		}

		return json_decode(json_encode($this->response->{$this->method}), $asArray);
	}
	/**
	 * Returns the Result Count
	 * @method getResultCount
	 * @author PA
	 * @date   2017-01-10
	 * @return int|false   false if no ResultCount is present
	 */
	public function getResultCount() : int
	{
		$count = false;

		if (isset($this->response->{$this->method}->Results)) {
			$attributes = $this->response->{$this->method}->Results->attributes();
			$count = (int) $attributes['ResultTotal'] ?? false;
		}

		return $count;
	}

}
