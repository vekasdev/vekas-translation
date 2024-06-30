<?php
namespace Vekas\Translation;

use Vekas\Translation\Interfaces\TranslateAdapterInterface;

class VekasTranslator implements TranslateAdapterInterface { 

    private $sourceLang = "";
    private $targetLang = "";
    

    function __construct(
        private $langLoader
    ) {

    }
    function setSourceLang($lang) {

    }
    function setTargetLang($lang)
    {
        
    }

    // function translate($text): string {
    //     $dictionery = $this->langLoader->load("en","ar"); 
    // }
    
}