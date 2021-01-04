<?php
namespace App\SocialData;

interface SocialGatewayContract{

    public function siteCall($provider);

    public function siteConnect($provider);

}