<?php

namespace Vekas\Translation\Interfaces;

interface LanguagePairInterface {
    function getSourceLang();
    function getTargetLang();
    function switchLanguages();
}