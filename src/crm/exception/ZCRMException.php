<?php
namespace zcrmsdk\crm\exception;

class ZCRMException extends \Exception
{
    
    protected $message = 'Unknown exception';
    
    // Exception message
    private $string;
    
    // Unknown
    protected $code = 0;
    
    // User-defined exception code
    protected $file;
    
    // Source filename of exception
    protected $line;
    
    // Source line of exception
    private $trace;
    
    private $exceptionCode = "Unknown";
    
    private $exceptionDetails = array();
    
    public function __construct($message = null, $code = 0)
    {
        if (! $message) {
            throw new $this('Unknown ' . get_class($this));
        }
        parent::__construct($message, $code);
    }
    
    public function __toString()
    {
        return get_class($this) . " Caused by:'{$this->message}' in {$this->file}({$this->line})\n" . "{$this->getTraceAsString()}";
    }
    
    /**
     * exceptionCode
     *
     * @return String
     */
    public function getExceptionCode()
    {
        return $this->exceptionCode;
    }
    
    /**
     * exceptionCode
     *
     * @param String $exceptionCode
     */
    public function setExceptionCode($exceptionCode)
    {
        $this->exceptionCode = $exceptionCode;
    }
    
    /**
     * To get the Exception details if any
     *
     * @return array with exception details
     */
    public function getExceptionDetails()
    {
        return $this->exceptionDetails;
    }
    
    /**
     * To set the Exception details if any
     *
     * @param array with exception details
     */
    public function setExceptionDetails($exceptionDetails)
    {
        $this->exceptionDetails = $exceptionDetails;
    }
}