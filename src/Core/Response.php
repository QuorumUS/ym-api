<?php

namespace P2A\YourMembership\Core;

/**
 * Your Membership Response Object
 */
class Response
{
    private $method;
    private $response;

    public function __construct(string $method,  $response)
    {

        $this->method = $method;

        $body = $response->getBody();
        codecept_debug($body);
        $this->response = new \SimpleXMLElement($body);
        codecept_debug($this->response->asXml());
        if ($this->hasError()) {
            throw new YourMembershipException($this->getError(), $this->getErrorCode(), $this->method);
        }
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
        return (string)$this->response->ErrDesc;
    }
    /**
     * Converts the response to an Array
     * @method toArray
     * @author PA
     * @date   2017-01-10
     * @return array      Response
     */
    public function toArray() : array
    {
        return json_decode(json_encode($this->response->{$this->method}), TRUE);
    }
    /**
     * Returns the Result Count
     * @method getResultCount
     * @author PA
     * @date   2017-01-10
     * @return int|false   false if no ResultCount is present
     */
    public function getResultCount()
    {
        $count = false;

        if (isset($this->response->Results)) {
            $attributes = $this->response->Results->getAttributes();
            $count  = $attributes['ResultTotal'] ?? false;
        }

        return count;
    }

}
