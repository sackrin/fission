<?php

/**
 * 99. BLOG SANDBOX
 */

use Fission\Example\Mock\MockDB;
use Fission\Hydrate\Reactor;
use Fission\Schema\Atom;
use Fission\Support\Press;
use Fission\Walker\Values;

use Fission\Example\Blog\Nuclei\BlogNuclei;

include('../../vendor/autoload.php');

$atom = Atom::create('blog');

$atom->nuclei(BlogNuclei::class);

$reactor = Reactor::using($atom)->scope('r')->roles('guest');

$record = MockDB::post();

$isotopes = $reactor->with(Press::values($record));

$values = Values::gather($isotopes)->all();

echo json_encode($values);