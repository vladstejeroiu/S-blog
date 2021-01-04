<?php

namespace App\SocialSites;

use App\SocialData\SocialGatewayContract;

class SiteDetails 
{   
    private $socialGateway;

    public function __construct(SocialGatewayContract $socialGateway){

        $this->socialGateway=$socialGateway;
        
    }

    public function callSite($provider){
        
        return $this->socialGateway->siteCall($provider);

    }
}
