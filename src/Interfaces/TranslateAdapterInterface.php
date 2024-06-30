<?php
namespace Vekas\Translation\Interfaces;
interface TranslateAdapterInterface {
    function translate($text) : string;
}