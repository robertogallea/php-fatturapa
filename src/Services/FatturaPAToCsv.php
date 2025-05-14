<?php
/**
 * Created by PhpStorm.
 * User: robertogallea
 * Date: 6/13/15
 * Time: 11:35 AM
 */

namespace Robertogallea\FatturaPA\Services;

use Robertogallea\FatturaPA\FatturaPA;
use Robertogallea\FatturaPA\Model\FatturaBase;


abstract class FatturaPAToCsv
{

    protected $fatture = [];
    protected $currentFilename;
    protected $currentFattura;
    protected $currentBody;

    protected $config;
    protected $csvSet;
    protected $csvType;
    protected $elements;


    protected $separator = ';';
    protected $separatorReplacement = ' - ';
    protected $breakline = "\n";
    protected $decimalPointForExporting = ',';


    public static function factory($fatture = [], $csvType = 'totali', $configFile = null)
    {

        if (is_null($configFile)) {
            $configFile = __DIR__ . '/FatturaPAToCsv/config/fatturapa_to_csv.php';
        }
        if (!file_exists($configFile)) {
            throw new \Exception("Configuration file ".$configFile." not found");
        }
        $config = include_once $configFile;


        if (!static::arrayGet(static::arrayGet($config,'types',[]),$csvType)) {
            throw new \InvalidArgumentException("Csv type not defined in configuration");
        }

        $csvSetClassName = static::buildCsvSetClassName($csvType,$config);

        return new $csvSetClassName($fatture,$config,$csvType);
    }

    public static function buildCsvSetClassName($csvType,$config) {


        $csvSetName = static::arrayGet($config['types'][$csvType],'set',false);

        if ($csvSetName === false) {
            throw new \InvalidArgumentException("You must include a 'set' in the csv type definition");
        }

        $csvSetConfig = static::arrayGet($config['sets'],$csvSetName,[]);

        if (array_key_exists('class_name',$csvSetConfig)) {
            return $csvSetConfig['class_name'];
        }

        $setsDefaultNamespace = static::arrayGet($csvSetConfig,'sets_default_namespace',"\\Robertogallea\\FatturaPA\\Services\\FatturaPAToCsv");

        $csvSetClassName = "Csv".static::camelCase($csvSetName)."Set";

        return $setsDefaultNamespace."\\".$csvSetClassName;
    }

    public function __construct($fatture,$config,$csvType) {
        $this->fatture = $fatture;
        $this->config = $config;
        $this->csvType = $csvType;

        $csvTypeConfiguration = $this->config['types'][$this->csvType];

        $this->elements = static::arrayGet($csvTypeConfiguration,'elements');

        if (!is_array($this->elements)) {
            throw new \InvalidArgumentException("Elements of csv type must be defined and must be an array");
        }

        $this->detailLevel = static::arrayGet($csvTypeConfiguration,'detail_level',$this->getDefaultDetailLevel());

    }


    protected function getDefaultDetailLevel() {
        $sets = static::arrayGet($this->config['sets'],$this->csvSet,[]);

        return static::arrayGet($sets,'default_detail_level',
            last(static::arrayGet($sets,'components',[])));
    }


    protected function getElementMethodName($element) {
        return 'get'.str_replace(' ','',ucwords(str_replace(['.','-', '_'], ' ', $element))).'Element';
    }

    protected function addFatturaRow() {

        $csvRow = "";
        foreach ($this->elements as $element) {

            $methodName = $this->getElementMethodName($element);
            $csvRow .= $this->$methodName() . $this->separator;

        }

        return $csvRow . $this->breakline;

    }

    public function getCsvFile($csvFilename, $force = false)
    {

        if (file_exists($csvFilename) && !$force) {
            throw new \Exception($csvFilename . " is already present in the filesystem. Choose another file or use the 'force' option");
        }

        $csvContent = $this->buildCsv();

        $file = fopen($csvFilename, 'w+');
        fwrite($file, $csvContent);
        fclose($file);
    }

    /**
     * @param string $separator
     */
    public function setSeparator(string $separator)
    {
        $this->separator = $separator;
    }

    /**
     * @param string $separatorReplacement
     */
    public function setSeparatorReplacement(string $separatorReplacement)
    {
        $this->separatorReplacement = $separatorReplacement;
    }

    /**
     * @param string $breakline
     */
    public function setBreakline(string $breakline)
    {
        $this->breakline = $breakline;
    }

    /**
     * @param string $decimalPointForExporting
     */
    public function setDecimalPointForExporting(string $decimalPointForExporting)
    {
        $this->decimalPointForExporting = $decimalPointForExporting;
    }


    protected function buildCsv()
    {
        $csvContent = $this->setHeaders();

        foreach ($this->fatture as $fattura) {

            $this->currentFilename = null;
            if (is_string($fattura)) {
                if (!file_exists($fattura)) {
                    throw new \Exception($fattura . " not found.");
                }
                $this->currentFilename = substr($fattura, strrpos($fattura, '/') + 1);
                $fattura = FatturaPA::readFromXML($fattura, '1.2.1');
            }


            if (!($fattura instanceof FatturaBase)) {
                throw new \InvalidArgumentException("Trynig to convert to csv a non-FatturaPA element");
            }

            $this->currentFattura = $fattura;

            $csvContent .= $this->addFatturaRows();

        }

        return $csvContent;
    }

    abstract protected function addFatturaRows();

    public function setLabels($labels) {
        $this->config['labels'] = array_merge($this->config['labels'],$labels);
    }

    public function getLabels() {
        return $this->config['labels'];
    }




    protected function setHeaders() {

        $customHeadersMethodName =  'setHeaders'.self::camelCase($this->csvType);
        if (method_exists($this,$customHeadersMethodName)) {
            return $this->$customHeadersMethodName();
        }

        $labels = $this->config['labels'];
        $elements = $this->elements;

        $headerLine = "";
        foreach ($elements as $element) {
            if (!array_key_exists($element,$labels)) {
                $label = $element;
            } else {
                $label = $labels[$element];
            }

            $headerLine .= $label . $this->separator;
        }

        return $headerLine . $this->breakline;
    }


    /*
     * return numbers formatted with 2 decimals
     */
    protected function formatNumbers($var) {
        return filter_var($var, \FILTER_CALLBACK, ['options' => function($el) {
            return number_format($el, 2, $this->decimalPointForExporting, '');
        }]);
    }


    /*
     * Replace the object's separator character in a value
     * NO NESTED ARRAYS
     */
    protected function replaceSeparator($part)
    {
        if (is_array($part)) {
            $part = implode($this->separatorReplacement, $part);
        }
        return str_replace($this->separator, $this->separatorReplacement, $part);
    }


    protected static function camelCase($string,$characters = ['-','_']) {
        return str_replace(' ','',ucwords(str_replace($characters, ' ', $string)));
    }

    protected static function arrayGet($array,$element,$default = null) {

        return array_key_exists($element,$array)
            ? $array[$element]
            : $default;
    }


    /*
     * For video debugging
     */
    protected function echoPart($part)
    {

        echo '<pre>';
        print_r($part);
        echo '</pre>';

    }


}
