<?php

namespace App\Tests\Infrastructure\Converter;

use App\Infrastructure\Converter\XmlToObjectConverter;
use PHPUnit\Framework\TestCase;

class XmlToObjectConverterTest extends TestCase
{

    /**
     * @var string
     */
    protected string $xml;

    protected function setUp()
    {
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
            <people>
                <person>
                  <personid>2</personid>
                  <personname>Name 2</personname>
                  <phones>
                    <phone>4444444</phone>
                  </phones>
                </person>
            </people>';
    }

    public function testToObjectIsNotEmpty(): void
    {
        $xml = simplexml_load_string($this->xml);
        $people = (new XmlToObjectConverter($xml))->toObject();

        $this->assertNotEmpty($people);
    }

    public function testToObjectIsObject(): void
    {
        $xml = simplexml_load_string($this->xml);
        $people = (new XmlToObjectConverter($xml))->toObject();

        $this->assertEquals($people->person->personid, '2');
    }

    public function testToObjectInstance(): void
    {
        $xml = simplexml_load_string($this->xml);
        $people = (new XmlToObjectConverter($xml))->toObject();

        $this->assertInstanceOf('\stdClass', $people);
    }

    public function testToObjectInstanceTypeErrorException(): void
    {
        $this->expectException(\TypeError::class);

        (new XmlToObjectConverter(''))->toObject();
    }

    public function testToObjectInstanceInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot convert to Object, xml value not found.');

        $xml = simplexml_load_string('<?xml version="1.0" encoding="utf-8"?> <people></people>');
        (new XmlToObjectConverter($xml))->toObject();
    }

    public function testToArrayIsNotEmpty(): void
    {
        $xml = simplexml_load_string($this->xml);
        $people = (new XmlToObjectConverter($xml))->toArray();

        $this->assertNotEmpty($people);
    }

    public function testToArrayIsArray(): void
    {
        $xml = simplexml_load_string($this->xml);
        $people = (new XmlToObjectConverter($xml))->toArray();

        $this->assertIsArray($people);
    }

    public function testToArrayHasKey(): void
    {
        $xml = simplexml_load_string($this->xml);
        $people = (new XmlToObjectConverter($xml))->toArray();

        $this->assertArrayHasKey('person', $people);
    }

    public function testToArrayInstanceTypeErrorException(): void
    {
        $this->expectException(\TypeError::class);

        (new XmlToObjectConverter(''))->toArray();
    }

    public function testToArrayInstanceInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot convert to Array, XML value not found.');

        $xml = simplexml_load_string('<?xml version="1.0" encoding="utf-8"?> <people></people>');
        (new XmlToObjectConverter($xml))->toArray();
    }
}
