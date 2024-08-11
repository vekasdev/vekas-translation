<?php

namespace Vekas\Translation\Interfaces;
use Vekas\Translation\Exceptions\InvalidLanguageValueException;

interface DictionaryInterface {

    /**
     * Check if an item exists.
     * 
     * @param string $item
     * @return bool
     * @throws InvalidLanguageValueException if the item set in language are diffrent than the source
     */
    public function itemExist($item);

    /**
     * Find the opposite (or corresponding value) of an item.
     * 
     * @param string $item
     * @return string
     * @throws InvalidLanguageValueException if the item set in language are diffrent than the source
     */
    public function findOpposit($item);

    /**
     * Remove an item.
     * 
     * @param string $item
     * @return bool
     * @throws InvalidLanguageValueException if the item set in language are diffrent than the source
     */
    public function removeItem($item);

    /**
     * Add an item to the dictionary array and save it to the source.
     * 
     * @param string $source
     * @param string $target
     * @param bool $force if item exist and you want to update it
     * @return void
     * @throws InvalidLanguageValueException if the item set in language are diffrent than the source
     */
    public function addItem($source, $target, $force = false);
    
}
