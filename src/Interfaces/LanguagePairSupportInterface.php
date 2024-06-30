<?php

namespace Vekas\Translation\Interfaces;


interface LanguagePairSupportInterface {
    function setSourceLang($lang);
    function setTargetLang($lang);
}