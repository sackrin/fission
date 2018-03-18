<?php

namespace Fission\Example\Blog\Nuclei;

use Fission\Schema\Nucleus;
use Fission\Schema\Policy\Allow;
use Fission\Schema\Policy\Deny;
use Fission\Support\ObjectNuclei;
use Fission\Support\Type;

class BlogNuclei extends ObjectNuclei {

    public function __construct()
    {
        $this->nuclei = [
            Nucleus::create('id')
                ->type(Type::string())
                ->policies([
                    Allow::for('user,guest')->scope('r'),
                    Allow::for('owner,administrator')->scope('*'),
                ]),
            Nucleus::create('title')
                ->type(Type::string())
                ->policies([
                    Allow::for('user,guest')->scope('r'),
                    Allow::for('owner,administrator')->scope('*'),
                ]),
            Nucleus::create('slug')
                ->type(Type::string())
                ->policies([
                    Allow::for('user,guest')->scope('r'),
                    Allow::for('owner,administrator')->scope('*'),
                ]),
            Nucleus::create('summary')
                ->type(Type::string())
                ->policies([
                    Deny::for('*')->scope('*'),
                    Allow::for('user,guest')->scope('r'),
                    Allow::for('owner,administrator')->scope('*'),
                ]),
            Nucleus::create('authors')
                ->type(Type::collection())
                ->policies([
                    Deny::for('*')->scope('*'),
                    Allow::for('user')->scope('r'),
                    Allow::for('owner,administrator')->scope('*'),
                ])
                ->nuclei(AuthorNuclei::class)
        ];
    }

}