<?php

namespace P2A\YourMembership;

class YourMembershipClient {

    public static $API_VERSION = '1.62';
    public static $BASE_URL = 'https://api.yourmembership.com';

    /**
     * [$callID description]
     * @var [type]
     */
    private $callID;

    /**
     * [$sessionID description]
     * @var [type]
     */
    private $sessionID;

    /**
     * [$apiKey description]
     * @var [type]
     */
    private $apiKey;


    public function __construct() {

    }

    /**
     * Builds Base Request For YourMembership API
     * @method buildBaseRequest
     * @author PA
     * @date   2017-01-09
     * @return [type]           [description]
     */
    private function buildBaseRequest() {

    }

}
