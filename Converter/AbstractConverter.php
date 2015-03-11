<?php
namespace O3Co\Crawler\Converter;

use O3Co\Crawler\Converter;
use Psr\Log\LoggerInterface,
	Psr\Log\LoggerAwareInterface,
	Psr\Log\NullLogger
;

/**
 * AbstractConverter 
 * 
 * @uses Converter
 * @abstract
 * @package { PACKAGE }
 * @copyright { COPYRIGHT } (c) { COMPANY }
 * @author Yoshi <yoshi@1o1.co.jp> 
 * @license { LICENSE }
 */
abstract class AbstractConverter implements Converter, LoggerAwareInterface
{
	static public function createConverterWithArgs(array $args = array())
	{
		list($valueOnInvalid, $skipOnInvalid) = self::pullArgsFromArray($args);
		return new static($valueOnInvalid, $skipOnInvalid);
	}

	static public function pullArgsFromArray(array $args)
	{
		$valueOnInvalid = null;
		$skipOnInvalid = false;
		$debug = false;

		if(isset($args['on-invalid'])) {
			$valueOnInvalid = $args['on-invalid'];
		}

		if(isset($args['skip-on-invalid'])) {
			$skipOnInvalid = (bool)$args['skip-on-invalid'];
		}

		return array($valueOnInvalid, $skipOnInvalid);
	}

	/**
	 * valueOnInvalid 
	 * 
	 * @var mixed
	 * @access private
	 */
	protected $valueOnInvalid = null;

	/**
	 * skipOnInvalid 
	 * 
	 * @var mixed
	 * @access private
	 */
	protected $skipOnInvalid = false;

	protected $logger;

	public function __construct($valueOnInvalid = null, $skipOnInvalid = false)
	{
		$this->valueOnInvalid = $valueOnInvalid;
		$this->skipOnInvalid = $skipOnInvalid;
	}

	public function convert($value)
	{
		if(!$this->isValid($value)) {
			if($this->skipOnInvalid) {
				return $value;
			} else {
				$this->getLogger()->debug(sprintf('%s::Converted Value From [%s] to [%s]', get_class($this), var_export($value, true), var_export($this->valueOnInvalid, true)));
				return $this->valueOnInvalid;
			}
		}
		$converted = $this->doConvert($value);

		$this->getLogger()->debug(sprintf('%s::Converted Value From [%s] to [%s]', __CLASS__, var_export($value, true), var_export($converted, true)));

		return $converted;
	}

	protected function isValid($value)
	{
		return true;
	}

	abstract protected function doConvert($value);

	public function isSkipOnInvalid()
	{
		return (bool)$this->skipOnInvalid;
	}
    
    public function getValueOnInvalid()
    {
        return $this->valueOnInvalid;
    }
    
    public function setValueOnInvalid($valueOnInvalid)
    {
        $this->valueOnInvalid = $valueOnInvalid;
        return $this;
    }
    
    public function getLogger()
    {
		if(!$this->logger) {
			$this->logger = new NullLogger();
		}
        return $this->logger;
    }
    
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }
}

