<?php

namespace Tests\Unit\Schema\Policy;

use Fission\Policy\HasRolesTrait;
use PHPUnit\Framework\TestCase;

class RolesTraitTest extends TestCase {

    public $mocked;

    public function setUp() {

        $this->mocked = $this->getMockForTrait(HasRolesTrait::class);
    }

    public function testAddingRoles() {

        $mocked = $this->mocked;

        $this->assertTrue(method_exists($mocked, 'roles'), 'Does not have method roles');

        $mocked->roles(['guest', 'user']);

        $this->assertContains('guest', $mocked->roles->toArray(), 'Does not contain an injected role');
    }

    public function testCheckingSingleRole() {

        $mocked = $this->mocked;

        $mocked->roles(['guest', 'user']);

        $this->assertTrue($mocked->inRoles(['guest']), 'No match on a single role it does have');

        $this->assertFalse($mocked->inRoles(['outsider']), 'Match on a single role it does not have');
    }

    public function testCheckingMultipleRole() {

        $mocked = $this->mocked;

        $mocked->roles(['guest', 'user']);

        $this->assertTrue($mocked->inRoles(['guest', 'user']), 'No match on multiple roles it does have');

        $this->assertTrue($mocked->inRoles(['guest', 'outsider']), 'No match on multiple roles it does have mixed with some it does not');

        $this->assertFalse($mocked->inRoles(['outsider', 'member']), 'Matching on multiple roles it does not have');
    }

    public function testCheckingMixedRoles() {

        $mocked = $this->mocked;

        $mocked->roles(['guest', 'user']);

        $this->assertTrue($mocked->inRoles(['guest', 'user', 'else']), 'Class is reporting no match on roles with multiple allowed and disallowed roles');
    }

}