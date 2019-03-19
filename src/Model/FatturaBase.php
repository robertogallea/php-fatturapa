<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:49
 */

namespace Robertogallea\FatturaPA\Model;


use Sabre\Xml\XmlSerializable;

abstract class FatturaBase implements XmlSerializable
{
    const PRIVATI_12 = 'FPR12';
    const PUBBLICA_AMMINISTRAZIONE_12 = 'FPA12';

    /** @var string */
    protected $versione;

    /**
     * @return string
     */
    public function getVersione()
    {
        return $this->versione;
    }

    /**
     * @param string $Versione
     * @return FatturaBase
     */
    public function setVersione($versione)
    {
        $this->versione = $versione;
        return $this;
    }

}