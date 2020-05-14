<?php

namespace Kiryi\Pathyi;

class Formatter
{
    public function format(
        string $path,
        bool $leadingSlash = false,
        bool $trailingSlash = false
    ): string {
        $path = trim($path);
        $slash = $this->getSlashType($path);
        
        $path = $this->formatPathStart($path, $slash, $leadingSlash);
        $path = $this->formatPathEnd($path, $slash, $trailingSlash);
        
        return $path;
    }
    
    private function getSlashType(string $path): string
    {
        if (strpos($path, '\\') !== false && strpos($path, '/') === false) {
            return '\\';
        } else {
            return '/';
        }
    }
    
    private function formatPathStart(string $path, string $slash, bool $leadingSlash): string
    {
        if ($leadingSlash !== false) {
            if ($path[0] != $slash) {
                $path = $slash . $path;
            }
            
            return $path;
        } else {
            if ($path[0] == $slash) {
                $path = substr($path, 1);
            }
            
            return $path;
        }
    }
    
    private function formatPathEnd(string $path, string $slash, bool $trailingSlash): string
    {
        if ($trailingSlash !== false) {
            if ($path[-1] != $slash) {
                $path .= $slash;
            }
            
            return $path;
        } else {
            if ($path[-1] == $slash) {
                $path = substr($path, 0, -1);
            }
            
            return $path;
        }
    }
}
