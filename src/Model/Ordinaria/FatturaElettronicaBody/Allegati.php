<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:35
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody;


use PhpZip\Exception\ZipException;
use PhpZip\ZipFile;
use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Allegati implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $NomeAttachment;

    /** @var string */
    protected $AlgoritmoCompressione;

    /** @var string */
    protected $FormatoAttachment;

    /** @var string */
    protected $DescrizioneAttachment;

    /** @var string */
    protected $Attachment;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}NomeAttachment') {
                $this->NomeAttachment = $child['value'];
            } elseif ($child['name'] === '{}AlgoritmoCompressione') {
                $this->AlgoritmoCompressione = $child['value'];
            } elseif ($child['name'] === '{}FormatoAttachment') {
                $this->FormatoAttachment = $child['value'];
            } elseif ($child['name'] === '{}DescrizioneAttachment') {
                $this->DescrizioneAttachment = $child['value'];
            } elseif ($child['name'] === '{}Attachment') {
                $this->Attachment = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->NomeAttachment ? $data['NomeAttachment'] = $this->NomeAttachment : null;
        $this->AlgoritmoCompressione ? $data['AlgoritmoCompressione'] = $this->AlgoritmoCompressione : null;
        $this->FormatoAttachment ? $data['FormatoAttachment'] = $this->FormatoAttachment : null;
        $this->DescrizioneAttachment ? $data['DescrizioneAttachment'] = $this->DescrizioneAttachment : null;
        $this->Attachment ? $data['Attachment'] = $this->Attachment : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getNomeAttachment()
    {
        return $this->NomeAttachment;
    }

    /**
     * @param string $NomeAttachment
     * @return Allegati
     */
    public function setNomeAttachment($NomeAttachment)
    {
        if (strlen($NomeAttachment) > 60) {
            throw new InvalidValueException("NomeAttachment must be a string of maximum 60 characters");
        }
        $this->NomeAttachment = $NomeAttachment;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlgoritmoCompressione()
    {
        return $this->AlgoritmoCompressione;
    }

    /**
     * @param string $AlgoritmoCompressione
     * @return Allegati
     */
    public function setAlgoritmoCompressione($AlgoritmoCompressione)
    {
        if (strlen($AlgoritmoCompressione) > 10) {
            throw new InvalidValueException("AlgoritmoCompressione must be a string of maximum 10 characters");
        }
        $this->AlgoritmoCompressione = $AlgoritmoCompressione;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormatoAttachment()
    {
        return $this->FormatoAttachment;
    }

    /**
     * @param string $FormatoAttachment
     * @return Allegati
     */
    public function setFormatoAttachment($FormatoAttachment)
    {
        if (strlen($FormatoAttachment) > 10) {
            throw new InvalidValueException("FormatoAttachment must be a string of maximum 10 characters");
        }
        $this->FormatoAttachment = $FormatoAttachment;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescrizioneAttachment()
    {
        return $this->DescrizioneAttachment;
    }

    /**
     * @param string $DescrizioneAttachment
     * @return Allegati
     */
    public function setDescrizioneAttachment($DescrizioneAttachment)
    {
        if (strlen($DescrizioneAttachment) > 100) {
            throw new InvalidValueException("DescrizioneAttachment must be a string of maximum 100 characters");
        }
        $this->DescrizioneAttachment = $DescrizioneAttachment;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttachment()
    {
        return $this->Attachment;
    }

    /**
     * @param string $Attachment
     * @return Allegati
     */
    public function setAttachment($Attachment)
    {
        $this->Attachment = $Attachment;
        return $this;
    }

    /**
     * @param string $filename
     * @param string $nome
     * @param string $descrizione
     * @param string $compression
     * @return Allegati
     */
    public static function createFromFile($filename, $nome, $descrizione, $compression = 'zip')
    {
        $allegati = new Allegati();
        $allegati->setNomeAttachment($nome);
        $allegati->setDescrizioneAttachment($descrizione);

        if ($compression === 'zip') {
            $res = Allegati::zip($filename);
        }

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $allegati->setAlgoritmoCompressione($compression);
        $allegati->setFormatoAttachment($ext);
        $allegati->setAttachment($res);
        return $allegati;
    }

    /**
     * @param string $location
     */
    public function saveToFile($location)
    {
        if ($this->getAlgoritmoCompressione() === 'zip') {
            self::unzip(base64_decode($this->getAttachment()), $location);
        }
    }

    private static function zip($file)
    {
        $zipFile = new ZipFile();
        try {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $data = $zipFile
                ->addFile($file, $filename . '.' . $ext)// add an entry from the file
                ->outputAsString();
            $data = base64_encode($data);
        } catch (ZipException $ex) {
            echo($ex);
        }

        return $data;
    }

    private static function unzip($data, $filename)
    {
        $zipFile = new ZipFile();
        try {
            $zipFile
                ->openFromString($data)
                ->extractTo($filename);
        } catch (ZipException $ex) {
            echo $ex;
        }
    }
}
