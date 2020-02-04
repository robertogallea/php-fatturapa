<?php
/**
 * Created by PhpStorm.
 * User: robertogallea
 * Date: 6/13/15
 * Time: 11:35 AM
 */

namespace Robertogallea\FatturaPA\Services;

use Robertogallea\FatturaPA\FatturaPA;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\Anagrafica;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\IdFiscaleIVA;
use Robertogallea\FatturaPA\Model\Common\Sede;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\Allegati;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee\AltriDatiGestionali;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee\CodiceArticolo;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi\DatiRiepilogo;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiTrasporto\DatiAnagraficiVettore;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiGeneraliDocumento\DatiBollo;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiGeneraliDocumento\DatiCassaPrevidenziale;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiDDT;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiGeneraliDocumento;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiOrdineAcquisto;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiGeneraliDocumento\DatiRitenuta;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiSAL;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiTrasporto;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\FatturaPrincipale;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiTrasporto\IndirizzoResa;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiPagamento;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiPagamento\DettaglioPagamento;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiVeicoli;
use Robertogallea\FatturaPA\Model\Common\ScontoMaggiorazione;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CedentePrestatore;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CedentePrestatore\Contatti;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CedentePrestatore\IscrizioneREA;
use Robertogallea\FatturaPA\Model\Common\StabileOrganizzazione;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CessionarioCommittente;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\DatiTrasmissione\ContattiTrasmittente;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\DatiTrasmissione;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\DatiTrasmissione\IdTrasmittente;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\RappresentanteFiscale;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\TerzoIntermediarioOSoggettoEmittente;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaOrdinaria;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;
use Sabre\Xml\Reader;
use Sabre\Xml\Service;
use Sabre\Xml\Writer;


class FatturaPAToCsv
{

    protected $filenames = [];
    protected $separator = ';';
    protected $breakline = "\n";
    protected $csvType;

    public function __construct($filenames = [], $csvType = null) {

        $this->filenames = $filenames;
        $this->csvType = $csvType;

    }


    public function getCsvFile($filename,$force = false) {

        if (file_exists($filename) && !$force) {
            throw new \Exception($filename. " is already present in the filesystem. Choose another file or use the 'force' option");
        }

        $csvContent = $this->buildCsv();

        $file = fopen($filename,'0755');
        fwrite($file,$csvContent);
        fclose($file);
    }


    protected function buildCsv() {
        $csvContent = $this->setHeaders();

        $rowNumber = 1;
        $aliquote = [];
        foreach ($this->filenames as $filename) {
            if (!file_exists($filename)) {
                throw new \Exception( $filename. " not found.");
            }


            $csvContent = $this->addFatturaRow($filename,$rowNumber,$csvContent,$aliquote);

            $rowNumber++;
        }

        return $csvContent;
    }

    protected function setHeaders() {

        $headers = [

            'Prog.',
            'Data ricezione',
            'Data fattura',
            'Numero',
            'Partita Iva',
            'Denominazione',
            'Imponibile totale',
            'Imposta totale',
            'Importo totale',
            'Arrotondamento',
            'File',

            'Aliquota 1',
            'Imponibile aliquota 1',
            'Imposta aliquota 1',
            'Importo aliquota 1',
            'Aliquota 2',
            'Imponibile aliquota 2',
            'Imposta aliquota 2',
            'Importo aliquota 2',
            'Aliquota 3',
            'Imponibile aliquota 3',
            'Imposta aliquota 3',
            'Importo aliquota 3',

            'Importo esente',
        ];

        return implode($this->separator,$headers) . $this->breakline;


    }


    protected function addFatturaRow($filename,$rowNumber,$csvContent,&$aliquote) {
        $fattura = FatturaPA::readFromXML($filename,'1.2.1');

        $row = [
            'Prog.' => $rowNumber,
            'Data ricezione' => '',
            'Data fattura' => '',
            'Numero' => '',
            'Partita Iva' => '',
            'Denominazione' => '',
            'Imponibile totale' => '',
            'Imposta totale' => '',
            'Importo totale' => '',
            'Arrotondamento' => '',
            'File' => substr($filename,strrpos($filename,'/')+1),

            'Aliquota 1' => '',
            'Imponibile aliquota 1' => '',
            'Imposta aliquota 1' => '',
            'Importo aliquota 1' => '',
            'Aliquota 2' => '',
            'Imponibile aliquota 2' => '',
            'Imposta aliquota 2' => '',
            'Importo aliquota 2' => '',
            'Aliquota 3' => '',
            'Imponibile aliquota 3' => '',
            'Imposta aliquota 3' => '',
            'Importo aliquota 3' => '',

            'Importo esente' => '',

        ];



        return $csvContent . implode($this->separator,array_values($row)) . $this->breakline;;
    }





}
