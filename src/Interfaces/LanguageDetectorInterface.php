<?php


namespace Vekas\Translation\Interfaces;


interface LanguageDetectorInterface {

    /**
     * @return string
     */
    function detect($text) ;
}