<?php

namespace Vekas\Translation;
use Vekas\Translation\Interfaces\DictionaryInterface;

class NullDictionary implements DictionaryInterface {

    /**
     * @inheritDoc
     */
    public function itemExist($item) {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function findOpposit($item) {
        return $item;
    }

    /**
     * @inheritDoc
     */
    public function removeItem($item) {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function addItem($source, $target, $force = false) {
        
    }

    function switchLanguages() {
        
    }
}
