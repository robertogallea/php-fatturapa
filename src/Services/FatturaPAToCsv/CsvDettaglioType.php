<?php
/**
 * Created by PhpStorm.
 * User: robertogallea
 * Date: 6/13/15
 * Time: 11:35 AM
 */

namespace Robertogallea\FatturaPA\Services\FatturaPAToCsv;

use Robertogallea\FatturaPA\FatturaPA;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici;
use Robertogallea\FatturaPA\Services\FatturaPAToCsv;


class CsvDettaglioType extends FatturaPAToCsv
{

    public function __construct($filenames = [])
    {

        $this->fatture = $filenames;

    }

    protected function setHeaders()
    {

        $headers = [

            'File',
            'Partita Iva',
            'Denominazione',

            'Data ricezione',
            'Data fattura',
            'Numero',
            'Causale',
            'Importo documento',
            'Arrotondamento documento',

            'Descrizione',
            'Prezzo',
            'Aliquota',

            'Imponibile',
            'Imposta',
            'Importo',
            'Arrotondamento',

        ];

        return implode($this->separator, $headers) . $this->breakline;


    }


    protected function addFatturaRows($fattura, $csvContent)
    {
        $fatturaRowsHeader = $this->getFatturaRowsHeader($fattura);

        $fatturaBodies = $fattura->getFatturaElettronicaBody();

        foreach ($fatturaBodies as $fatturaBody) {
            $fatturaRowsBodyGenerali = $this->getFatturaRowsBodyGenerali($fatturaBody);
            $fatturaBodyDatiRiepilogo = $fatturaBody->getDatiBeniServizi()->getDatiRiepilogo();


            $riepiloghi = $this->calculateDatiRiepilogo($fatturaBodyDatiRiepilogo);

            $fatturaBodyDettagliLinee = $fatturaBody->getDatiBeniServizi()->getDettaglioLinee();

            foreach ($fatturaBodyDettagliLinee as $fatturaBodyDettaglioLinea) {

                $dettaglioLinea = $this->getFatturaRowsBodyDettaglioLinea($fatturaBodyDettaglioLinea);

                $aliquota = $dettaglioLinea['Aliquota'];
                unset($dettaglioLinea['Aliquota']);


                $rowArray = array_merge(
                    ['File' => $this->currentFilename],
                    $fatturaRowsHeader,
                    $fatturaRowsBodyGenerali,
                    $dettaglioLinea,
                    ['Aliquota' => $this->formatNumbers((float)$aliquota)],
                    $riepiloghi[$aliquota]
                );

                $csvContent .= implode($this->separator, array_values($rowArray)) . $this->breakline;
            }
        }

        return $csvContent;
    }

    protected function getFatturaRowsBodyDettaglioLinea($fatturaBodyDettaglioLinea)
    {


        $descrizione = $this->replaceSeparator($fatturaBodyDettaglioLinea->getDescrizione());
        $prezzo = $fatturaBodyDettaglioLinea->getPrezzoTotale();
        $aliquota = $fatturaBodyDettaglioLinea->getAliquotaIVA();
        return
            [
                'Descrizione' => $descrizione,
                'Prezzo' => $this->formatNumbers((float)$prezzo),
                'Aliquota' => $aliquota,
            ];
    }

}
