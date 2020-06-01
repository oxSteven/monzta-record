<?php

namespace Kiryi\MonztaRecord\Helper;

class FilterHandler
{
    public function filterRegion(string $filter, object $record): bool
    {
        if (strtolower($record->region) == $filter) {
            return true;
        } else {
            return false;
        }
    }

    public function filterClass(string $filter, object $record): bool
    {
        if (strtolower($record->class) == $filter) {
            return true;
        } else {
            return false;
        }
    }

    public function filterType(string $filter, object $record): bool
    {
        if (in_array($filter, $record->tags)) {
            return true;
        } else {
            return false;
        }
    }
 
    public function filterOther(string $filter, object $record): bool
    {
        if (in_array($filter, $record->tags)) {
            return true;
        } else {
            return false;
        }
    }
}
