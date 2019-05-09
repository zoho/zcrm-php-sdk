<?php
namespace zcrmsdk\oauth\utility;

class ZohoOAuthParams
{
    
    private $clientId;
    
    private $clientSecret;
    
    private $redirectUrl;
    
    private $accessType;
    
    private $scopes;
    
    public function getClientId()
    {
        return $this->clientId;
    }
    
    public function setClientId($clientId)
    {
        return $this->clientId = $clientId;
    }
    
    public function getClientSecret()
    {
        return $this->clientSecret;
    }
    
    public function setClientSecret($clientSecret)
    {
        return $this->clientSecret = $clientSecret;
    }
    
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }
    
    public function setRedirectUrl($redirectUrl)
    {
        return $this->redirectUrl = $redirectUrl;
    }
    
    public function getAccessType()
    {
        return $this->accessType;
    }
    
    public function setAccessType($accessType)
    {
        return $this->accessType = $accessType;
    }
    
    public function getScopes()
    {
        return $this->scopes;
    }
    
    public function setScopes($scopes)
    {
        return $this->scopes = $scopes;
    }
}