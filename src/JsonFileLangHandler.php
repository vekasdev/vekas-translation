<?php
namespace Vekas\Translation;

use PhpParser\JsonDecoder;
use Vekas\Translation\Exceptions\FileNotExistException;
use Vekas\Translation\Exceptions\ItemAlreadyExistException;
use Vekas\Translation\Interfaces\LangLoaderInterface;
use Vekas\Translation\Interfaces\LanguagePairSupportInterface;
use Vekas\Translation\Interfaces\LangHandlerInterface;
class JsonFileLangHandler implements LangLoaderInterface , LangHandlerInterface  {
    private $data = [];

    private $source = "";

    private $target = "";

    private $swapped = false;

    function __construct (
      private string $directory ,
      private string $separator = "" ,
      $source ,
      $target 
      ) {
        $this->source = $source;
        $this->target = $target;
        $this->load();
      }

    /**
     * this have ability to swap two languages if the pair given not exist
     * @inheritDoc
     */
    function load() {
        $data = [];
        $path = $this->getFullPath();
        $file = file_get_contents($path);

        // if file not exist 
        
        if ( $file == false ) {
            
            // then swap the pairs of two languages (to the original language)

            $this->swapLanguages();

            // try to get contents from the original order of the two languages

            $file = file_get_contents($this->getFullPath());

            // if not get the file throw exception

            if ($file == false ) {
                throw new FileNotExistException( " file of the translation dictionery are not exist  ");
            }

            // finaly ( flip the data , mark as swapped , and swapping )

            $data = array_flip ( json_decode($file,true) ) ;
            $this->swapLanguages();
            $this->swapState();
            
        } else {
            $data = json_decode($file,true);
        }

        $this->data = $data;
        return $this->data; 
    }


    function findMappings() {
        $mappings = glob($this->directory."/*.json");

        foreach ( $mappings as &$mapping ) {
            $mapping = $this->getMappingInfo(
                basename($mapping)
            );
        }

        return $mappings ? $mappings : [];
    }


    function getSource() {
        return $this->source;
    }

    function getTarget() {
        return $this->target;
    }


    function getMappingInfo($fileName) {
        $fileName = rtrim($fileName,".json");
        $data = explode($this->separator,$fileName);

        $source = $data[0];
        $target = end($data);

        return [
          "sourceLanguage" => $source,
          "targetLanguage" => $target
        ];
    }

    function getFileName($filePath) {
        return basename($filePath);
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
     * @throws FileNotExistException if the file of the mapping not exist
     */
    function update($arr) {
        $json = json_encode($arr);
        if (!file_exists($this->getFullPath())) {
            throw new FileNotExistException("file on path : " . $this->getFullPath() . " is not exist");
        }
        return file_put_contents($this->getFullPath(),$json) !== false ? true : false ;
    }

    function flipData() {
        $this->data = array_flip($this->data);
    }
    function swapState() {
        $this->swapped = (bool) ! $this->swapped;
    }
    function swapLanguages() {
        $source = $this->source;
        $this->source = $this->target;
        $this->target = $source;
    }


    function addItem($source, $target,$force = false) {

        if ($this->isSwapped()) {
            
            if ( array_key_exists ( $source , $this->data ) && ! $force ) { 
                throw new ItemAlreadyExistException;
            }
            
            $this->data[$source] = $target; // add the item into the local variable

            /* returning the data into its original order */

            $this->flipData();

            $this->swapState();

            $this->swapLanguages();

            /* returning the data into its original order  */
            
            $this->update($this->data);
            
            $this->flipData();

            $this->swapState();

            $this->swapLanguages();
            
        } else {
            if ( array_key_exists ( $source , $this->data ) && ! $force ) {
                throw new ItemAlreadyExistException;
            }
            $this->data[$source] = $target;
            $this->update($this->data);
        }
        
    }

    function getItem($source) {
        $item = isset($this->data[$source]) ? $this->data[$source] : null ;
        return $item;
    }

    function removeItem($item) {
        if ( isset($item) ) {
            unset($this->data[$item]);
            if ($this->isSwapped()) {

                /* returning the data into its original order */

                $this->flipData();

                $this->swapState();

                $this->swapLanguages();

                /* returning the data into its original order  */
                
                $this->update($this->data);
                
                $this->flipData();

                $this->swapState();

                $this->swapLanguages();

            } else {
                $this->update($this->data);
            }

            return true;
        }
        return false;
    }

    
    function setSource($source) {
        $this->source = $source;
    }

    function setTarget($target) {
        $this->target = $target;       
    }

    function isSwapped() {
        return $this->swapped;
    }
}



// if i have en2ar.json  => the search must be s -> en  t -> ar
// if the user want the opposit like => s -> ar   t-> en