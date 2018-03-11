<?php

namespace Tests\Unit;

use Fission\Schema\Atom;
use Fission\Schema\Nucleus;
use PHPUnit\Framework\TestCase;

final class AtomTest extends TestCase {

    public $atom;

    public function setUp() {
        $this->atom = Atom::create('acme');
    }

    public function testCreateInstance() {

        $this->assertObjectHasAttribute( 'machine', $this->atom);

        $this->assertAttributeEquals('acme', 'machine', $this->atom, 'Machine name not properly populated');
    }

    public function testAddingRoles() {

        $this->assertTrue(method_exists($this->atom, 'roles'), 'Does not have method roles');

        $this->atom->roles(['guest', 'user']);

        $this->assertContains('guest', $this->atom->roles->toArray(), 'Does not contain an injected role');
    }

    public function testCheckingSingleRole() {

        $this->atom->roles(['guest', 'user']);

        $this->assertTrue($this->atom->inRoles(['guest']), 'No match on a single role it does have');

        $this->assertFalse($this->atom->inRoles(['outsider']), 'Match on a single role it does not have');
    }

    public function testCheckingMultipleRole() {

        $this->atom->roles(['guest', 'user']);

        $this->assertTrue($this->atom->inRoles(['guest', 'user']), 'No match on multiple roles it does have');

        $this->assertTrue($this->atom->inRoles(['guest', 'outsider']), 'No match on multiple roles it does have mixed with some it does not');

        $this->assertFalse($this->atom->inRoles(['outsider', 'member']), 'Matching on multiple roles it does not have');
    }

    public function testCheckingMixedRoles() {

        $this->atom->roles(['guest', 'user']);

        $this->assertTrue($this->atom->inRoles(['guest', 'user', 'else']), 'Class is reporting no match on roles with multiple allowed and disallowed roles');
    }

    public function testAddingScope() {

        $this->assertTrue(method_exists($this->atom, 'scope'), 'Does not have method scope');

        $this->atom->scope(['r', 'w']);

        $this->assertContains('w', $this->atom->scope->toArray(), 'Does not contain an injected scope');
    }

    public function testCheckingSingleScope() {

        $this->atom->scope(['r', 'w']);

        $this->assertTrue($this->atom->inScope(['r']), 'No match on a single scope it does have');

        $this->assertFalse($this->atom->inScope(['rw']), 'Match on a single scope it does not have');
    }

    public function testCheckingMultipleScope() {

        $this->atom->scope(['r', 'w']);

        $this->assertTrue($this->atom->inScope(['r', 'w']), 'No match on multiple scope it does have');

        $this->assertTrue($this->atom->inScope(['r', 'rw']), 'No match on multiple scope it does have mixed with some it does not');

        $this->assertFalse($this->atom->inScope(['rw', 'd']), 'Matching on multiple scope it does not have');
    }

    public function testCheckingMixedScopes() {

        $this->atom->scope(['r', 'w']);

        $this->assertTrue($this->atom->inScope(['r', 'w', 'rw']), 'Class is reporting no match on scope with multiple allowed and disallowed scope');
    }

    public function testNucleiInjection() {

        $this->assertObjectHasAttribute( 'nuclei', $this->atom);

        $this->atom->nuclei([
            Nucleus::create('first_name'),
            Nucleus::create('last_name')
        ]);

    }
}