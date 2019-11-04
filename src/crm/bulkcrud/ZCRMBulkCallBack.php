<?php
namespace zcrmsdk\crm\bulkcrud;

class ZCRMBulkCallBack
{
    /**
     * callback url
     * @var string
     */
    private $url = null;
    
    /**
     * request method
     * @var string
     */
    private $method = null;
    
    
    /**
     * constructor to set the callback url and method
     * @param string $url
     * @param string $method
     */
    private function __construct($url, $method)
    {
        $this->url = $url;
        $this->method = $method;
    }
    
    /**
     * Method to get the instance of the ZCRMBulkCallBack class
     * @param string $url
     * @param string $method
     * @return ZCRMBulkCallBack - instance
     */
    public static function getInstance($url = null, $method = null)
    {
        return new ZCRMBulkCallBack($url, $method);
    }
    
    /**
     * Method to get a valid URL, which should allow HTTP POST method.
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * Method to get the HTTP method of the callback url.
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
    
    /**
     * Method to set a valid URL, which should allow HTTP POST method.
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    /**
     * Method to set the HTTP method of the callback url. Only HTTP POST method is supported.
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }
}
?>