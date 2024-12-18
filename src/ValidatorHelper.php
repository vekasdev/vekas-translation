<?php 


namespace Vekas\Translation;

class ValidatorHelper {

    static public $validatorsPath = __DIR__."/LanguageValidators";
    static public $validatorsNamespace = "Vekas\Translation\LanguageValidators";
    
    static function getLanguageCodes(){
        $codes = [];
        foreach(glob(self::$validatorsPath."/*.php") as $validatorPath) {
            $pathinfo = pathinfo($validatorPath);
            $className = $pathinfo["filename"];
            $validatorObject = new (self::$validatorsNamespace."\\".$className);
            $langType = $validatorObject->getType();
            array_push($codes,$langType);
        }
        return $codes;
    }
}