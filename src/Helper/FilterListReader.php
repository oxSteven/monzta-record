<?php

namespace Kiryi\MonztaRecord\Helper;

class FilterListReader
{
	const FILEPATH_FILTERCONFIG = __DIR__ . '/../../config/filter.json';

	public function read(): object
	{
		return json_decode(file_get_contents($this::FILEPATH_FILTERCONFIG));
	}
}
