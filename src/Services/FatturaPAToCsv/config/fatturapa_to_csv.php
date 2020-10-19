<?php

return [

    'sets_default_namespace' => "\\Robertogallea\\FatturaPA\\Services\\FatturaPAToCsv",
    'sets' => [
        'contabilita' => [
            'components' => [
                'header',
                'documento',
                'riepilogoiva',
                'dettagliolinea'
            ],
            'default_detail_level' => 'dettagliolinea',
            //'class_name' => "\\Robertogallea\\FatturaPA\\Services\\FatturaPAToCsv\\CsvContabilitaSet"
        ],
    ],
    'available_elements' => [

        'header' => [
            'file',
            'partitaiva-cedente',
            'denominazione-cedente',
            'partitaiva-cessionario',
            'denominazione-cessionario',
        ],

        'documento' => [

            'data-ricezione',
            'data-fattura',
            'numero',
            'causale',
            'importo',
            'arrotondamento',
            'descrizioni',
        ],

        'riepilogoiva' => [

            'aliquota',
            'imponibile',
            'imposta',
            'importo',
            'arrotondamento',
        ],

        'dettagliolinea' => [
            'prezzo',
            'descrizione',
            'aliquota',
        ],

    ],

    'types' => [
        'totali' => [
            'set' => 'contabilita',
            'detail_level' => 'documento',
            'elements' => [
                'header.file',
                'documento.numero',
                'documento.data-fattura',
                'header.denominazione-cedente',
                'header.partitaiva-cedente',
                'documento.data-ricezione',
                'documento.importo',
                'documento.arrotondamento',
                'documento.causale',
                'documento.descrizioni',
            ]
        ],

        'riepilogo' => [
            'set' => 'contabilita',
            'detail_level' => 'riepilogoiva',
            'elements' => [
                'header.file',
                'documento.numero',
                'documento.data-fattura',
                'header.denominazione-cedente',
                'header.partitaiva-cedente',
                'riepilogoiva.imponibile',
                'riepilogoiva.aliquota',
                'riepilogoiva.imposta',
                'riepilogoiva.importo',
                'riepilogoiva.arrotondamento',
                'documento.importo',
                'documento.arrotondamento',
                'documento.descrizioni',
                'documento.data-ricezione',
                'documento.causale',
            ]
        ],
        'dettaglio' => [
            'set' => 'contabilita',
            'detail_level' => 'dettagliolinea',
            'elements' => [
                'header.file',
                'header.partitaiva-cedente',
                'header.denominazione-cedente',
                'documento.data-ricezione',
                'documento.data-fattura',
                'documento.numero',
                'documento.causale',
                'documento.importo',
                'documento.arrotondamento',
                'riepilogoiva.aliquota',
                'riepilogoiva.imponibile',
                'riepilogoiva.imposta',
                'riepilogoiva.importo',
                'riepilogoiva.arrotondamento',
                'dettagliolinea.prezzo',
                'dettagliolinea.descrizione',
//                'dettagliolinea.aliquota',
            ]
        ],
    ],

    'labels' => [


        'header.file' => 'File',
        'header.partitaiva-cedente' => 'Partita Iva',
        'header.denominazione-cedente' => 'Denominazione',
        'header.partitaiva-cessionario' => 'Partita Iva (committente)',
        'header.denominazione-cessionario' => 'Denominazione (committente)',

        'documento.data-ricezione' => 'Data ricezione',
        'documento.data-fattura' => 'Data fattura',
        'documento.numero' => 'Numero fattura',
        'documento.causale' => 'Causale',
        'documento.importo' => 'Importo fattura',
        'documento.arrotondamento' => 'Arrotondamento fattura',
        'documento.descrizioni' => 'Descrizioni articoli',


        'riepilogoiva.aliquota' => 'Aliquota',
        'riepilogoiva.imponibile' => 'Imponibile',
        'riepilogoiva.imposta' => 'Imposta',
        'riepilogoiva.importo' => 'Importo',
        'riepilogoiva.arrotondamento' => 'Arrotondamento',

        'dettagliolinea.prezzo' => 'Prezzo',
        'dettagliolinea.descrizione' => 'Descrizione',
        'dettagliolinea.aliquota' => 'Aliquota dettaglio',
    ],


];
