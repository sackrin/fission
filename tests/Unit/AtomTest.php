<?php

namespace Tests\Unit;

use Fission\Schema\Atom;
use PHPUnit\Framework\TestCase;

final class AtomTest extends TestCase {

    public function testCreateInstance() {

        $schema = Atom::create('person');

        $this->assertEquals('blah', 'blah');
    }

    public function testRolesInjection() {

    }

    public function testScopeInjection() {

    }

    public function testNucleiInjection() {

    }
}