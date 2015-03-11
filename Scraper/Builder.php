<?php
namespace O3Co\Crawler\Scraper;

interface Builder
{
	function setSelector($selector);

	function setFieldKey($key);

	function setConverters(array $converters);

	function setMultiResponse($isMulti);

	function setChildren(array $scrapers);

	function build();
}
