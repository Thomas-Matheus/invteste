<?php

namespace App\Infrastructure\Converter;

class XmlToObjectConverter
{

    /**
     * @var \SimpleXMLElement
     */
    private \SimpleXMLElement $xml;

    /**
     * XmlToObjectConverter constructor.
     * @param \SimpleXMLElement $xml
     */
    public function __construct(\SimpleXMLElement $xml)
    {
        $this->xml = $xml;
    }

    public function toObject(): Object
    {
        if (empty($this->xml)) {
            throw new \InvalidArgumentException('Cannot convert to Object, xml value not found.');
        }

        return json_decode(json_encode($this->xml));
    }

    public function toArray(): array
    {
        if (empty($this->xml)) {
            throw new \InvalidArgumentException('Cannot convert to Array, XML value not found.');
        }

        return json_decode(json_encode($this->xml), true);
    }
}
