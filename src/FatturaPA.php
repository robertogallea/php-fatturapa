<?php
/**
 * Created by PhpStorm.
 * User: robertogallea
 * Date: 6/13/15
 * Time: 11:35 AM
 */

namespace Robertogallea\FatturaPA;

use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\Anagrafica;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\IdFiscaleIVA;
use Robertogallea\FatturaPA\Model\Common\Sede;
use Robertogallea\FatturaPA\Model\FatturaBase;
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
use Robertogallea\FatturaPA\Services\FatturaPAToCsv;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;
use Sabre\Xml\Reader;
use Sabre\Xml\Service;
use Sabre\Xml\Writer;


class FatturaPA
{

    const AVAILABLE_VALIDATIONS = ['1.2.1'];


    /**
     * @param $filename
     * @param null $validateVersion
     * @return FatturaBase
     */
    public static function readFromXML($filename, $validateVersion = '1.2.1')
    {
        $file = fopen($filename, "r") or die("Unable to open file!");
        $string = fread($file, filesize($filename));
        return self::readFromString($string, $validateVersion);
    }

    /**
     * @param $string
     * @param null $validateVersion
     * @return FatturaBase
     * @throws \Sabre\Xml\ParseException
     */
    public static function readFromString($string, $validateVersion = '1.2.1')
    {

        self::validate($string, $validateVersion);

        $service = new Service();
        $service->elementMap = [

            '{http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2}FatturaElettronica' => function (Reader $reader) {
                $fatturaElettronica = new FatturaOrdinaria();
                $fatturaElettronica->traverse($reader);

                return $fatturaElettronica;
            },

            /*
             * HEADER
             */

            'FatturaElettronicaHeader' => function (Reader $reader) {
                $fatturaElettronicaHeader = new FatturaElettronicaHeader();
                $fatturaElettronicaHeader->traverse($reader);

                return $fatturaElettronicaHeader;

            },

            'DatiTrasmissione' => function (Reader $reader) {
                $datiTrasmissione = new DatiTrasmissione();
                $datiTrasmissione->traverse($reader);

                return $datiTrasmissione;
            },

            'IdTrasmittente' => function (Reader $reader) {
                $idTrasmittente = new IdTrasmittente();
                $idTrasmittente->traverse($reader);

                return $idTrasmittente;
            },

            'ContattiTrasmittente' => function (Reader $reader) {
                $idTrasmittente = new ContattiTrasmittente();
                $idTrasmittente->traverse($reader);

                return $idTrasmittente;
            },

            'CedentePrestatore' => function (Reader $reader) {
                $cedentePrestatore = new CedentePrestatore();
                $cedentePrestatore->traverse($reader);

                return $cedentePrestatore;
            },

            'DatiAnagrafici' => function (Reader $reader) {
                $datiAnagrafici = new DatiAnagrafici();
                $datiAnagrafici->traverse($reader);

                return $datiAnagrafici;
            },

            'IdFiscaleIVA' => function (Reader $reader) {
                $idFiscaleIVA = new IdFiscaleIVA();
                $idFiscaleIVA->traverse($reader);

                return $idFiscaleIVA;
            },

            'Anagrafica' => function (Reader $reader) {
                $anagrafica = new Anagrafica();
                $anagrafica->traverse($reader);

                return $anagrafica;
            },

            'Sede' => function (Reader $reader) {
                $sede = new Sede();
                $sede->traverse($reader);

                return $sede;
            },

            'StabileOrganizzazione' => function (Reader $reader) {
                $stabileOrganizzazione = new StabileOrganizzazione();
                $stabileOrganizzazione->traverse($reader);

                return $stabileOrganizzazione;
            },

            'IscrizioneREA' => function (Reader $reader) {
                $iscrizioneREA = new IscrizioneREA();
                $iscrizioneREA->traverse($reader);

                return $iscrizioneREA;
            },

            'Contatti' => function (Reader $reader) {
                $contatti = new Contatti();
                $contatti->traverse($reader);

                return $contatti;
            },

            'RappresentanteFiscale' => function (Reader $reader) {
                $rappresentanteFiscale = new RappresentanteFiscale();
                $rappresentanteFiscale->traverse($reader);

                return $rappresentanteFiscale;
            },

            'CessionarioCommittente' => function (Reader $reader) {
                $cessionarioCommittente = new CessionarioCommittente();
                $cessionarioCommittente->traverse($reader);

                return $cessionarioCommittente;
            },


            'TerzoIntermediarioOSoggettoEmittente' => function (Reader $reader) {
                $terzoIntermediarioOSoggettoEmittente = new TerzoIntermediarioOSoggettoEmittente();
                $terzoIntermediarioOSoggettoEmittente->traverse($reader);

                return $terzoIntermediarioOSoggettoEmittente;
            },


            /*
             * BODY
             */

            'FatturaElettronicaBody' => function (Reader $reader) {
                $fatturaElettronicaBody = new FatturaElettronicaBody();
                $fatturaElettronicaBody->traverse($reader);

                return $fatturaElettronicaBody;
            },

            'DatiGenerali' => function (Reader $reader) {
                $datiGenerali = new DatiGenerali();
                $datiGenerali->traverse($reader);

                return $datiGenerali;
            },

            'DatiGeneraliDocumento' => function (Reader $reader) {
                $datiGeneraliDocumento = new DatiGeneraliDocumento();
                $datiGeneraliDocumento->traverse($reader);

                return $datiGeneraliDocumento;
            },

            'DatiRitenuta' => function (Reader $reader) {
                $datiRitenuta = new DatiRitenuta();
                $datiRitenuta->traverse($reader);

                return $datiRitenuta;
            },

            'DatiBollo' => function (Reader $reader) {
                $datiBollo = new DatiBollo();
                $datiBollo->traverse($reader);

                return $datiBollo;
            },

            'DatiCassaPrevidenziale' => function (Reader $reader) {
                $datiCassaPrevidenziale = new DatiCassaPrevidenziale();
                $datiCassaPrevidenziale->traverse($reader);

                return $datiCassaPrevidenziale;
            },

            'ScontoMaggiorazione' => function (Reader $reader) {
                $scontoMaggiorazione = new ScontoMaggiorazione();
                $scontoMaggiorazione->traverse($reader);

                return $scontoMaggiorazione;
            },

            'DatiOrdineAcquisto' => function (Reader $reader) {
                $datiOrdineAcquisto = new DatiOrdineAcquisto();
                $datiOrdineAcquisto->traverse($reader);

                return $datiOrdineAcquisto;
            },

//            'DatiContratto' => function(Reader $reader) {
//                $datiContratto = new DatiContratto();
//                $datiContratto->traverse($reader);
//
//                return $datiContratto;
//            },
//
//            'DatiConvenzione' => function(Reader $reader) {
//                $datiConvenzione = new DatiConvenzione();
//                $datiConvenzione->traverse($reader);
//
//                return $datiConvenzione;
//            },
//
//            'DatiRicezione' => function(Reader $reader) {
//                $datiRicezione = new DatiRicezione();
//                $datiRicezione->traverse($reader);
//
//                return $datiRicezione;
//            },
//
//            'DatiFattureCollegate' => function(Reader $reader) {
//                $datiFattureCollegate = new DatiFattureCollegate();
//                $datiFattureCollegate->traverse($reader);
//
//                return $datiFattureCollegate;
//            },

            'DatiSAL' => function (Reader $reader) {
                $datiSAL = new DatiSAL();
                $datiSAL->traverse($reader);

                return $datiSAL;
            },

            'DatiDDT' => function (Reader $reader) {
                $datiDDT = new DatiDDT();
                $datiDDT->traverse($reader);

                return $datiDDT;
            },

            'DatiTrasporto' => function (Reader $reader) {
                $datiTrasporto = new DatiTrasporto();
                $datiTrasporto->traverse($reader);

                return $datiTrasporto;
            },

            'DatiAnagraficiVettore' => function (Reader $reader) {
                $datiAnagraficiVettore = new DatiAnagraficiVettore();
                $datiAnagraficiVettore->traverse($reader);

                return $datiAnagraficiVettore;
            },

            'IndirizzoResa' => function (Reader $reader) {
                $indirizzoResa = new IndirizzoResa();
                $indirizzoResa->traverse($reader);

                return $indirizzoResa;
            },

            'FatturaPrincipale' => function (Reader $reader) {
                $fatturaPrincipale = new FatturaPrincipale();
                $fatturaPrincipale->traverse($reader);

                return $fatturaPrincipale;
            },

            'DatiBeniServizi' => function (Reader $reader) {
                $datiBeniServizi = new DatiBeniServizi();
                $datiBeniServizi->traverse($reader);

                return $datiBeniServizi;
            },

            'DettaglioLinee' => function (Reader $reader) {
                $dettaglioLinee = new DettaglioLinee();
                $dettaglioLinee->traverse($reader);

                return $dettaglioLinee;
            },

            'CodiceArticolo' => function (Reader $reader) {
                $codiceArticolo = new CodiceArticolo();
                $codiceArticolo->traverse($reader);

                return $codiceArticolo;
            },

            'AltriDatiGestionali' => function (Reader $reader) {
                $altriDatiGestionali = new AltriDatiGestionali();
                $altriDatiGestionali->traverse($reader);

                return $altriDatiGestionali;
            },

            'DatiRiepilogo' => function (Reader $reader) {
                $datiRiepilogo = new DatiRiepilogo();
                $datiRiepilogo->traverse($reader);

                return $datiRiepilogo;
            },

            'DatiVeicoli' => function (Reader $reader) {
                $datiVeicoli = new DatiVeicoli();
                $datiVeicoli->traverse($reader);

                return $datiVeicoli;
            },

            'DatiPagamento' => function (Reader $reader) {
                $datiPagamento = new DatiPagamento();
                $datiPagamento->traverse($reader);

                return $datiPagamento;
            },

            'DettaglioPagamento' => function (Reader $reader) {
                $dettaglioPagamento = new DettaglioPagamento();
                $dettaglioPagamento->traverse($reader);

                return $dettaglioPagamento;
            },

            'Allegati' => function (Reader $reader) {
                $allegati = new Allegati();
                $allegati->traverse($reader);

                return $allegati;
            },

        ];

        return $service->parse($string);


    }

    public static function readFromSignedXML($filename, $validateVersion = '1.2.1')
    {
        $file = fopen($filename, "r") or die("Unable to open file!");
        $string = fread($file, filesize($filename));

        $parsedXML = self::stripP7MData($string);

        return self::readFromString($parsedXML, $validateVersion);
    }

    public static function writeToXMLString($fattura, $validateVersion = '1.2.1')
    {

        $service = new Service();
        $data = $service->write('{http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2}FatturaElettronica', function (Writer $writer) use ($fattura) {
            $writer->writeAttribute('versione', $fattura->getVersione());
            $writer->write($fattura);
        });
        self::validate($data, $validateVersion);
        return $data;
    }

    public static function writeToXML($fattura, $filename, $validateVersion = '1.2.1')
    {
        $xml = FatturaPA::writeToXMLString($fattura, $validateVersion);

        $file = fopen($filename, "w") or die("Unable to open file!");
        fwrite($file, $xml);
    }

    private static function stripP7MData($string)
    {

        $newString = preg_replace('/[[:^print:]]/', '', $string);

        $startXml = substr($newString, strpos($newString, '<?xml '));

        preg_match_all('/<\/.+?>/', $startXml, $matches, PREG_OFFSET_CAPTURE);
        $lastMatch = end($matches[0]);
        $str = substr($startXml, 0, $lastMatch[1]) . $lastMatch[0];
        $startAll = strpos($str, "<Allegati");
        if ($startAll !== false) {
            $endAll = strpos($str, "</Allegati>");
            $str = substr($str, 0, $startAll) . substr($str, ($endAll + 11));
        }

        return $str;
    }

    protected static function getFatturaPAValidationFile($validateVersion)
    {

        switch ($validateVersion) {
            case '1.2.1':
                return __DIR__ . "/xsd/VFPR12.xsd";
            default:
                throw new \InvalidArgumentException("Available validation schemas are: [ " . implode(', ', self::AVAILABLE_VALIDATIONS) . " ]");
        }

    }

    /*
     * throw Exception
     */
    protected static function validate($string, $validateVersion)
    {
        if ($validateVersion && $xsdValidationFile = self::getFatturaPAValidationFile($validateVersion)) {
            $xmlDoc = new \DOMDocument();
            $xmlDoc->loadXML($string);
            $xmlDoc->schemaValidate($xsdValidationFile);
        }
    }


    /**
     * @param $fatture - a single FatturaBase object or an array of FatturaBase objects to be converted (the element
     *                  or the elements of the array could also be a string representing a filename
     * @param $csvFilename - The name of the exported csv file
     * @param string $csvType - dettaglio|riepilogo|totali
     * @param bool $force - force the overwrite of the csv file
     *
     *
     */
    public static function convertFatturePAToCsv($fatture, $csvFilename, $csvType = 'riepilogo', $force = false) {

        if (!is_array($fatture)) {
            $fatture = [$fatture];
        }

        $csvService = FatturaPAToCsv::factory($fatture,$csvType);

        $csvService->getCsvFile($csvFilename,$force);

    }

}
