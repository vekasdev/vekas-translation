<?php


namespace Vekas\Translation\Interfaces;

use Vekas\Translation\Exceptions\FileNotExistException;
use Vekas\Translation\Exceptions\InvalidLanguageTypeException;
use Vekas\Translation\Exceptions\ItemAlreadyExistException;

interface LanguageRepositoryInterface {
    
    /**
     * @throws ItemAlreadyExistException when language pair provided are previously exist
     * @throws InvalidLanguageTypeException when language passed have no validator registered in the system
     */
    function create($sourceLang,$targetLang);


    /**
     * @throws FileNotExistException when language pair provided are not exist
     * @return true
     */
    function delete($sourceLang,$targetLang);
}