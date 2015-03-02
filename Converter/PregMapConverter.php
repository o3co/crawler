<?php
namespace O3Com\Crawler\Converter;

class PregMapConverter extends MapConverter 
{
	protected function doConvert($value) 
	{
		foreach($this->getMaps() as $pattern => $mapValue) {
			if(preg_match($pattern, $value)) {
				return $mapValue;
			}
		}

		if($this->skipOnInvalid) {
			return $value;
		}

		return $this->valueOnInvalid;
	}
}

