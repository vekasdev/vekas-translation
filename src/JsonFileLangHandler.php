<?php
namespace Vekas\Translation;

use Vekas\Translation\Exceptions\FileNotExistException;
use Vekas\Translation\Exceptions\ItemAlreadyExistException;
use Vekas\Translation\Interfaces\LangLoaderInterface;
use Vekas\Translation\Interfaces\LanguagePairSupportInterface;
use Vekas\Translation\Interfaces\LangHandlerInterface;
class JsonFileLangHandler implements LangLoaderInterface , LangHandlerInterface  {
    private $data = [];

    private $source = "";

    private $target = "";

    function __construct (
      private string $directory ,
      private string $separator = "" ,
      $source ,
      $target 
      ) {
        $this->source = $source;
        $this->target = $target;
      }

    /**
     * @inheritDoc
     */
    function load() {
        $path = $this->getFullPath();
        $file = file_get_contents($path);
        if ( $file == false )  throw new FileNotExistException( "file of the translation dictionery not exist at path : $path" );
        $this->data = json_decode($file,true);
        return $this->data; 
    }

    function getFullPath() {
        return $this->directory."/".$this->source.$this->separator.$this->target.".json";
    }

    function getData() {
        return $this->data;
    }

    function setData($data) {
        $this->data = $data;
        return $this;
    }

    /**
     * @return bool false when file not written otherwise true 
     */
    function update($arr) {
        $json = json_encode($arr);
        return file_put_contents($this->getFullPath(),$json) !== false ? true : false ;
    }

    function addItem($source, $target,$force = false) {
        if ( array_key_exists ( $source , $this->data ) && ! $force ) {
            throw new ItemAlreadyExistException;
        }
        $this->data[$source] = $target;
        $this->update($this->data);
        return;
    }

    function setSource($source) {
        $this->source = $source;
    }

    function setTarget($target) {
        $this->target = $target;       
    }

}