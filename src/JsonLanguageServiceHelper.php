<?php  


namespace Vekas\Translation;

use Vekas\Translation\Interfaces\LanguageServiceHelperInterface;

class JsonLanguageServiceHelper implements LanguageServiceHelperInterface {
    private $directory = "";
    private $separator = "";

    function __construct($directory,$separator) {
        $this->directory = $directory;
        $this->separator = $separator;
    }

    function getLanguageMapping(){
        $result = [];
        foreach(glob($this->directory."/*.json") as $mapping){
            $pathinfo = pathinfo($mapping);
            $mappingName = $pathinfo["filename"];
            $pair = explode($this->separator,$mappingName);
            $result[$pair[0]][] = $pair[1];
        }
        return $result;
    }

    function getDirectory(){
        return $this->directory;
    }

    function getSeparator() {
        return $this->separator;
    }

} 