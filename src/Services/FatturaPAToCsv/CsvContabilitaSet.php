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


class CsvContabilitaSet extends FatturaPAToCsv
{

    use FatturaPAToCsv\Traits\HeaderMethodsTrait;
    use FatturaPAToCsv\Traits\DocumentoMethodsTrait;

    protected $csvSet = 'contabilita';

    protected $datiRiepilogoConDettagli = [];


    protected $currentRiepilogo;
    protected $currentAliquota;
    protected $currentDettaglioLinea;

    protected function addFatturaRows()
    {

        //Se voglio solo elementi dello header devo ritornare una singola riga per ogni fatturapa
        //senza dover ogranizzare strutture interne
        if ($this->detailLevel == 'header') {
            return $this->addFatturaRow();
        }


        $csvContent = "";
        //IN tutti gli altri casi devo analizzare il vettore del body e prepararmi le strutture dati
        foreach ($this->currentFattura->getFatturaElettronicaBody() as $fatturaBody) {
            $this->currentBody = $fatturaBody;
            $this->buildStructure();




            switch ($this->detailLevel) {
                //SE il livello di dettaglio è "documento" ritorno una riga per ogni body
                case 'documento':
                    $csvContent .= $this->addFatturaRow();
                break;
                //SE il livello di dettaglio è "riepilogoiva" ritorno una riga per ogni riepilogo iva calcolato
                case 'riepilogoiva' :
                    foreach ($this->datiRiepilogoConDettagli as $aliquota => $riepilogo) {
                        $this->currentRiepilogo = $riepilogo;
                        $this->currentAliquota = $aliquota;
                        $csvContent .= $this->addFatturaRow();
                    }
                break;
                //SE il livello di dettaglio è "dettagliolinea" ritorno una riga per ogni dettaglio linea calcolato
                case 'dettagliolinea' :
                    foreach ($this->datiRiepilogoConDettagli as $aliquota => $riepilogo) {
                        $this->currentRiepilogo = $riepilogo;
                        $this->currentAliquota = $aliquota;
                        foreach ($this->currentRiepilogo['dettagliolinee'] as $dettaglioLinea) {
                            $this->currentDettaglioLinea = $dettaglioLinea;
                            $csvContent .= $this->addFatturaRow();
                        }
                    }
                default:
                    break;
            }

        }

        return $csvContent;



    }




    protected function buildStructure()
    {

        $fatturaBody = $this->currentBody;

        $riepiloghi = [];

        //CALCULATE DATI RIPEILOGO
        $fatturaBodyDatiRiepilogo = $fatturaBody->getDatiBeniServizi()->getDatiRiepilogo();

        /*
         * Esistono fatture (fatte male ma che passano la validazione ministeriale) con riepiloghi iva ripetuti
         * con stessa aliquota....... (tipo fatture di nota compagnia telefonica.....)
        */
        foreach ($fatturaBodyDatiRiepilogo as $fatturaBodyDatoRiepilogo) {
            $imponibile = $fatturaBodyDatoRiepilogo->getImponibileImporto();
            $imposta = $fatturaBodyDatoRiepilogo->getImposta();
            $aliquota = $fatturaBodyDatoRiepilogo->getAliquotaIVA();
            if (!array_key_exists($aliquota, $riepiloghi)) {

                $riepiloghi[$aliquota]['Imponibile'] = (float)$imponibile;
                $riepiloghi[$aliquota]['Imposta'] = (float)$imposta;
                $riepiloghi[$aliquota]['Importo'] = (float)$imponibile + (float)$imposta;
                $riepiloghi[$aliquota]['Arrotondamento'] = (float)$fatturaBodyDatoRiepilogo->Arrotondamento();
                $riepiloghi[$aliquota]['dettagliolinee'] = [];
            } else {
                $riepiloghi[$aliquota]['Imponibile'] += (float)$imponibile;
                $riepiloghi[$aliquota]['Imposta'] += (float)$imposta;
                $riepiloghi[$aliquota]['Importo'] += (float)$imponibile + (float)$imposta;
                $riepiloghi[$aliquota]['Arrotondamento'] += (float)$fatturaBodyDatoRiepilogo->Arrotondamento();
            }

        }
        $riepiloghi = $this->formatNumbers($riepiloghi);

        //CALCULATE DETTAGLI LINEE
        $fatturaBodyDettagliLinee = $fatturaBody->getDatiBeniServizi()->getDettaglioLinee();
        foreach ($fatturaBodyDettagliLinee as $fatturaBodyDettaglioLinea) {

            $descrizione = $this->replaceSeparator($fatturaBodyDettaglioLinea->getDescrizione());
            $prezzo = $fatturaBodyDettaglioLinea->getPrezzoTotale();
            $aliquota = $fatturaBodyDettaglioLinea->getAliquotaIVA();

            $riepiloghi[$aliquota]['dettagliolinee'][] = [
                'Descrizione' => $descrizione,
                'Prezzo' => $this->formatNumbers((float)$prezzo),
                'Aliquota' => $this->formatNumbers((float)$aliquota),
            ];

        }

        $this->datiRiepilogoConDettagli = $riepiloghi;
    }


    protected function getRiepilogoivaAliquotaElement() {
        return $this->formatNumbers($this->currentAliquota);
    }
    protected function getRiepilogoivaImponibileElement() {
        return $this->currentRiepilogo['Imponibile'];
    }
    protected function getRiepilogoivaImpostaElement() {
        return $this->currentRiepilogo['Imposta'];
    }
    protected function getRiepilogoivaImportoElement() {
        return $this->currentRiepilogo['Importo'];
    }
    protected function getRiepilogoivaArrotondamentoElement() {
        return $this->currentRiepilogo['Arrotondamento'];
    }


    protected function getDettagliolineaPrezzoElement() {
        return $this->currentDettaglioLinea['Prezzo'];
    }
    protected function getDettagliolineaDescrizioneElement() {
        return $this->currentDettaglioLinea['Descrizione'];
    }
    protected function getDettagliolineaAliquotaElement() {
        return $this->currentDettaglioLinea['Aliquota'];
    }


}
