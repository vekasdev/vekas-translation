<?php
namespace Vekas\Translation;

use Vekas\Translation\Interfaces\DictionaryInterface;
use Vekas\Translation\Interfaces\TranslateAdapterInterface;
use Vekas\Translation\Exceptions\InvalidLanguageValueException;

class VekasTranslator implements TranslateAdapterInterface { 

    function __construct(
        private DictionaryInterface  $dictionary
    ) {

    }

    function translate($text): string {
        $translatedText = [];
        $text = $this->dividePhrase($text);
        foreach($text as $word) {
            $translatedText[] = $this->translateUnit($word);
        }
        return implode(" ",$translatedText);
    }

    function translateUnit($unit) {
        try {
            $translation =  $this->dictionary->findOpposit($unit) ;
            if ($translation == null )  return $unit;
        } catch (InvalidLanguageValueException $e) {
            return $unit;
        }
        return $translation;
    }

    function dividePhrase($phrase) {
        return explode(" ",$phrase);
    }

    function getDictionary() {
        return $this->dictionary;
    }

    function getLanguagePair() {
        $service = $this->dictionary->getLanguageService();
        return [
            "target" => $service->getTargetLang(),
            "source" => $service->getSourceLang()
        ];
    }

    function switchLanguages() {
        $this->dictionary->switchLanguage();
    }
    
}