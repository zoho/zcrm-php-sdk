<?php
namespace zcrmsdk\oauth\persistence;

interface ZohoOAuthPersistenceInterface
{
    
    public function saveOAuthData($zohoOAuthTokens);
    
    public function getOAuthTokens($userEmailId);
    
    public function deleteOAuthTokens($userEmailId);
}