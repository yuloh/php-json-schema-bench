<?php

namespace Swaggest\JsonSchemaBench\Tests\PHPUnit\BenchmarkDraft4;

use Swaggest\JsonSchema\InvalidValue;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchemaBench\Tests\PHPUnit\Spec\Draft4Test;

class Draft4SwaggestTest extends Draft4Test
{

    /*
    public function specOptionalProvider()
    {
        return array();
    }
    */


    /** @var \SplObjectStorage */
    private $schemas;
    protected function setUp()
    {
        $this->schemas = new \SplObjectStorage();
    }

    protected function skipTest($name)
    {
        return false;
        if ('definitions.json valid definition: valid definition schema [0]' === $name) {
            return false;
        } else {
            return true;
        }
        return parent::skipTest($name); // TODO: Change the autogenerated stub
    }

    /**
     * @param $schemaData
     * @param $data
     * @param $isValid
     * @param $name
     * @param $version
     * @throws \Exception
     */
    protected function runSpecTest($schemaData, $data, $isValid, $name, $version)
    {
        $actualValid = true;
        try {
            $options = $this->makeOptions($version);
            $options->schemasCache = $this->schemas;

            /*
            if ($this->schemas->contains($schemaData)) {
                $schema = $this->schemas->offsetGet($schemaData);
            } else {
                //$options->skipValidation = true;
                $schema = Schema::import($schemaData, $options);
                $this->schemas->attach($schemaData, $schema);
            }
            //*/


            $schema = Schema::import($schemaData, $options);

            $options->skipValidation = false;
            $options->validateOnly = true;
            $schema->in($data, $options);
        } catch (InvalidValue $exception) {
            $actualValid = false;
        }

        $this->assertSame($isValid, $actualValid, "Test: $name");
    }

}