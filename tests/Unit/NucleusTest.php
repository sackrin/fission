<?php

namespace Tests\Unit;

use Fission\Schema\Nucleus;
use Fission\Schema\Policy\Allow;
use Fission\Schema\Policy\Deny;
use Fission\Schema\Sanitizer\GUMPSanitizer;
use Fission\Schema\Validator\GUMPValidator;
use Fission\Support\Type;
use PHPUnit\Framework\TestCase;

final class NucleusTest extends TestCase {

    public $nucleus;

    public function setUp() {
        $this->nucleus = Nucleus::create('first_name');
    }

    public function testHasMachine() {

        $this->assertObjectHasAttribute( 'machine', $this->nucleus);

        $this->assertAttributeEquals('first_name', 'machine', $this->nucleus, 'Machine name not properly populated');
    }

    public function testAddType() {

        $this->assertObjectHasAttribute( 'type', $this->nucleus);

        $this->nucleus->type(Type::string());

        $this->assertAttributeEquals(Type::string(), 'type', $this->nucleus, 'Type name not properly populated');
    }

    public function testAddSanitizer() {

        $this->assertObjectHasAttribute( 'sanitizers', $this->nucleus);

        $this->nucleus->sanitizers([
            GUMPSanitizer::using("trim|sanitize_string")
        ]);
    }

    public function testAddValidator() {

        $this->assertObjectHasAttribute( 'validators', $this->nucleus);

        $this->nucleus->validators([
            GUMPValidator::against("required|min_len,5")
        ]);
    }

    public function testAddDenyPolicy() {

        $this->assertObjectHasAttribute( 'policies', $this->nucleus);

        $this->nucleus->policies([
            Deny::for("guest")->scope("w")
        ]);

    }

    public function testAddAllowPolicy() {

        $this->assertObjectHasAttribute( 'policies', $this->nucleus);

        $this->nucleus->policies([
            Allow::for("guest")->scope("r")
        ]);

    }
}