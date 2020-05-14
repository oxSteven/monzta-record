<?php

namespace Kiryi\Inyi;

use \Kiryi\Pathyi\Formatter as Pathyi;

class Reader extends \Exception
{
    const ERRORMSG_FILEDOESNOTEXIST = 'INYI FILE ERROR: File "%s" does not exist!';
    const ERRORMSG_FILEISBROKEN = 'INYI FILE ERROR: File "%s" is broken!';
    const ERRORMSG_KEYNOTFOUND = 'INYI KEY ERROR: Key "%s" is not set in file "%s"!';
    
    const ROOTDIR = __DIR__ . '/../../../../';
    
    private string $filepath = '';
    private array $ini = [];
    
    public function __construct(string $filepath)
    {
        $this->filepath = $this::ROOTDIR . (new Pathyi())->format($filepath);

        $this->ini = $this->loadIni();
    }
    
    public function get(string $key)
    {
        $key = trim($key);
        
        if (null !== $value = $this->getValue($key)) {
            return $value;
        } else {
            throw new \Exception(sprintf($this::ERRORMSG_KEYNOTFOUND, $key, $this->filepath));
        }
    }
    
    private function loadIni(): array
    {
        if (file_exists($this->filepath) === true) {
            if (false !== $ini = parse_ini_file($this->filepath, true)) {
                return $ini;
            } else {
                throw new \Exception(sprintf($this::ERRORMSG_FILEISBROKEN, $this->filepath));
            }
        } else {
            throw new \Exception(sprintf($this::ERRORMSG_FILEDOESNOTEXIST, $this->filepath));
        }
    }
    
    private function getValue(string $key)
    {
        $keyLevels = explode('::', $key);
        $value = $this->ini;
        
        for ($i = 0; $i != count($keyLevels); $i++) {
            if (isset($value[$keyLevels[$i]]) === true) {
                $value = $value[$keyLevels[$i]];
            } else {
                return null;
            }
        }
        
        return $value;
    }
}
