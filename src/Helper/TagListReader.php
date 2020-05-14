<?php

namespace Kiryi\MonztaRecord\Helper;

class TagListReader
{
	const FILEPATH_TAGLIST = __DIR__ . '/../../config/tags.json';

	public function read(): array
	{
		return json_decode(file_get_contents($this::FILEPATH_TAGLIST));
	}
}
