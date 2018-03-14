<?php

namespace Tests\Unit\Schema\Policy;

use Fission\Schema\Policy\ScopeTrait;
use PHPUnit\Framework\TestCase;

class ScopeTraitTest extends TestCase {

    public $mocked;

    public function setUp() {

        $this->mocked = $this->getMockForTrait(ScopeTrait::class);
    }

    public function testAddingScope() {

        $mocked = $this->mocked;
        
        $this->assertTrue(method_exists($mocked, 'scope'), 'Does not have method scope');

        $mocked->scope(['r', 'w']);

        $this->assertContains('w', $mocked->scope->toArray(), 'Does not contain an injected scope');
    }

    public function testCheckingSingleScope() {

        $mocked = $this->mocked;
        
        $mocked->scope(['r', 'w']);

        $this->assertTrue($mocked->inScope(['r']), 'No match on a single scope it does have');

        $this->assertFalse($mocked->inScope(['rw']), 'Match on a single scope it does not have');
    }

    public function testCheckingMultipleScope() {

        $mocked = $this->mocked;
        
        $mocked->scope(['r', 'w']);

        $this->assertTrue($mocked->inScope(['r', 'w']), 'No match on multiple scope it does have');

        $this->assertTrue($mocked->inScope(['r', 'rw']), 'No match on multiple scope it does have mixed with some it does not');

        $this->assertFalse($mocked->inScope(['rw', 'd']), 'Matching on multiple scope it does not have');
    }

    public function testCheckingMixedScopes() {

        $mocked = $this->mocked;
        
        $mocked->scope(['r', 'w']);

        $this->assertTrue($mocked->inScope(['r', 'w', 'rw']), 'Class is reporting no match on scope with multiple allowed and disallowed scope');
    }

}