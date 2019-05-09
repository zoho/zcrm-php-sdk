<?php
namespace zcrmsdk\oauth\exception;

class ZohoOAuthException extends \Exception
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
}