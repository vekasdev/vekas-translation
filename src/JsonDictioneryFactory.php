<?php

namespace Vekas\Translation;

use Vekas\Translation\JsonFileLangHandler;

class JsonDictionaryFactory {

    /**
     * Summary of getDictionery
     * @param string $directory
     * @param LanguageValidator $validator
     * @param string $source
     * @param string $target
     * @param string $separator
     * @return Dictionary
     */
    static function  getDictionery( $directory,$validator,$source,$target,$separator = 2 ) {
        $jsonFileLangHandler = new JsonFileLangHandler($directory,$separator,$source,$target);
        $dictionery = new Dictionary($jsonFileLangHandler,$validator);
        return $dictionery;
    }

}