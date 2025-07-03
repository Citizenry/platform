<?php

namespace StreetSignal\Tests\Unit\Modules\V2\Mappers;

use StreetSignal\Modules\V2\Mappers\FormMapper;
use StreetSignal\Core\Entity\Form;
use StreetSignal\Tests\Unit\Modules\V2\ImportMock;
use StreetSignal\Tests\TestCase;
use Mockery as M;
use Faker;

/**
 * @backupGlobals disabled
 * @preserveGlobalState disabled
 */
class FormMapperTest extends TestCase
{
    public function testMap()
    {
        $faker = Faker\Factory::create();
        $input = [
            'form_title' => 'Special form',
            'form_description' => 'A very very special form',
            'form_active' => '1',
        ];

        $mapper = new FormMapper();
        $import = ImportMock::forId(1);
        $result = $mapper($import, $input);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('result', $result);
        $form = $result['result'];

        $this->assertInstanceOf(Form::class, $form);
        $this->assertEquals('Special form', $form->name);
        $this->assertEquals('A very very special form', $form->description);
        $this->assertEquals(false, $form->disabled);
    }

    public function testMapDisabled()
    {
        $faker = Faker\Factory::create();
        $input = [
            'form_title' => 'Special form',
            'form_description' => 'A very very special form',
            'form_active' => '0',
        ];

        $mapper = new FormMapper();
        $import = ImportMock::forId(1);
        $result = $mapper($import, $input);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('result', $result);
        $form = $result['result'];

        $this->assertInstanceOf(Form::class, $form);
        $this->assertEquals('Special form', $form->name);
        $this->assertEquals('A very very special form', $form->description);
        $this->assertEquals(true, $form->disabled);
    }
}
