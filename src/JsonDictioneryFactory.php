<?php

namespace Vekas\Translation;

use Vekas\Translation\JsonFileLangHandler;

class JsonDictioneryFactory {
    static function  getDictionery( $directory,$source,$target,$separator = 2 ) {
        $jsonFileLangHandler = new JsonFileLangHandler($directory,$separator,$source,$target);
        $dictionery = new Dictionery($jsonFileLangHandler);
        return $dictionery;
    }
}