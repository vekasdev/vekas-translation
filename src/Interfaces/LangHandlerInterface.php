<?php


namespace Vekas\Translation\Interfaces;

use Vekas\Translation\Exceptions\ItemAlreadyExistException;
interface LangHandlerInterface {
    /**
     * @throws ItemAlreadyExistException when source item is already exist
     */
    function addItem($source, $target,$force = false);

    /**
     * @return mixed | null
     */
    function getItem($source);

    /**
     * @param string $item 
     * @return bool
     */
    function removeItem($item) ; 
}
