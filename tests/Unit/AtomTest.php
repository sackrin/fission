<?php

namespace Tests\Unit;

use Fission\Schema\Atom;
use Fission\Schema\Nucleus;
use PHPUnit\Framework\TestCase;

final class AtomTest extends TestCase {

    public $mocked;

    public function setUp() {
        $this->mocked = Atom::create('acme');
    }

    public function testCreateInstance() {

        $mocked = $this->mocked;

        $this->assertObjectHasAttribute( 'machine', $mocked);

        $this->assertAttributeEquals('acme', 'machine', $mocked, 'Machine name not properly populated');
    }

    public function testSettingMachineName() {

        $mocked = $this->mocked;

        $this->assertTrue(method_exists($mocked, 'getMachine'), 'Class does not have method getMachine');

        $this->assertTrue(method_exists($mocked, 'setMachine'), 'Class does not have method setMachine');

        $setter = $mocked->setMachine('tester');

        $this->assertTrue($setter === $mocked, 'Method setMachine not returning instance of self');

        $this->assertAttributeEquals('tester', 'machine', $mocked, 'Machine name not properly populated');

        $getter = $mocked->getMachine();

        $this->assertTrue($getter === 'tester', 'Method getMachine not returning correct machine name');
    }

    public function testNucleiInjection() {

        $mocked = $this->mocked;

        $this->assertObjectHasAttribute( 'nuclei', $mocked);

        $mocked->nuclei([
            Nucleus::create('first_name'),
            Nucleus::create('last_name')
        ]);

    }
}