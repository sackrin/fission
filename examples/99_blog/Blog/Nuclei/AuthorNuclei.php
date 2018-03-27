<?php

namespace Fission\Example\Blog\Nuclei;

use Fission\Nucleus\Nucleus;
use Fission\Policy\Allow;
use Fission\Policy\Deny;
use Fission\Support\ObjectNuclei;
use Fission\Support\Type;

class AuthorNuclei extends ObjectNuclei {

    public function __construct()
    {
        $this->nuclei = [
            Nucleus::create('id')
                ->type(Type::string()),
            Nucleus::create('first_name')
                ->type(Type::string()),
            Nucleus::create('last_name')
                ->type(Type::string()),
            Nucleus::create('email')
                ->type(Type::string())
        ];
    }

}