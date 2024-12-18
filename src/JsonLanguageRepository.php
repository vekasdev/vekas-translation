<?php


namespace Vekas\Translation;

use Vekas\Translation\Exceptions\InvalidLanguageTypeException;
use Vekas\Translation\Exceptions\ItemAlreadyExistException;
use Vekas\Translation\Interfaces\LanguageDetectorInterface;
use Vekas\Translation\Interfaces\LanguageRepositoryInterface;
use Vekas\Translation\Interfaces\LanguageServiceHelperInterface;

class JsonLanguageRepository implements LanguageRepositoryInterface {

    function __construct(
        private JsonLanguageHelper $jsonLanguageHelper,
    ) {}

    /**
     * @inheritDoc
     */
    function create($sourceLang, $targetLang) {
        $codes = ValidatorHelper::getLanguageCodes();

        if ( in_array($sourceLang,$codes ) == false ) {
            throw new InvalidLanguageTypeException("invalid language type passed : ".$sourceLang);
        } else if ( in_array($targetLang,$codes ) == false ) {
            throw new InvalidLanguageTypeException("invalid language type passed : " . $targetLang );
        }

        $mapping = $this->jsonLanguageHelper->getLanguageMapping();

        if ( key_exists($sourceLang,$mapping)  && in_array( $targetLang,$mapping[$sourceLang] ) ) {
            throw new ItemAlreadyExistException("the language pair provided are already exist");
        }

        $directory = $this->jsonLanguageHelper->getDirectory();
        $separator = $this->jsonLanguageHelper->getSeparator();

        $langFileName = $directory."/".$sourceLang.$separator.$targetLang.".json";
        
        if ( file_put_contents($langFileName,"{}") === false ) return false;
        return true;

    }

    function delete($sourceLang, $targetLang) {
        $directory = $this->jsonLanguageHelper->getDirectory();
        $separator = $this->jsonLanguageHelper->getSeparator();
        $langFilePath = $directory."/".$sourceLang.$separator.$targetLang.".json";
        return unlink($langFilePath) == true;
    }

    function getHelper() {
        return $this->jsonLanguageHelper;
    }
}