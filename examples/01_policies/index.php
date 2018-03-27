<?php

/**
 * 01. POLICIES FOR PROPERTY ACCESS CONTROL
 * This example extends off of previous examples
 * Create a policy driven schema to restrict actions based on roles and scope
 */

include('../../vendor/autoload.php');

use Fission\Reactor;
use Fission\Atom;
use Fission\Nucleus\Nucleus;
use Fission\Policy\Allow;
use Fission\Policy\Deny;
use Fission\Support\Press;
use Fission\Support\Type;
use Fission\Walker\Values;

$atom = Atom::create('person')
    // Teach the Atom instance about which roles that can be used
    // There are no set roles in fission, you can inject whatever roles your platform uses
    ->roles(['owner','administrator','user'])
    // Teach the Atom instance about which scopes can be used
    // Like with roles, you specify what scopes you want to use
    ->scope(['r','w']);

$nuclei = [
    Nucleus::create('first_name')
        ->type(Type::string())
        ->label('First Name')
        ->policies([
            // Add a wildcard policy to establish a deny for all
            // This is good to ensure that to begin with, all roles will be denied
            // You can then add allow rules for specific roles and scopes
            Deny::for("*")->scope("*"),
            // Setup an allow rule for all administrator and owner
            // We will allow both r and w scopes for an administrator and owner
            Allow::for(["administrator","owner"])->scope(["r","w"]),
            // Setup an allow rule for reading for role user
            Allow::for("user")->scope(["r"])
        ]),
    Nucleus::create('last_name')
        ->type(Type::string())
        ->label('Last Name')
        ->policies([
            Deny::for("*")->scope(["r","w"]),
            Allow::for("user")->scope(["r","w"])
        ])
];

$atom->nuclei($nuclei);

/**
 * WHEN ARE POLICIES APPLIED?
 * Policies are applied during the reaction process and are only applied to isotope instances.
 * The nucleus structure will not be restricted by policies as they are not aware of external roles and scope
 */
$reactor = Reactor::using($atom)
    // Add the roles relevant to the reactor purpose
    // For example, if we had a user then we would add the user's roles
    ->roles(['user'])
    // Do the same for the scope
    // For example, if this reactor were being called on a update endpoint you may want to use a w scope
    // Changing the scope to r or adding r to the scope array will grant both values
    ->scope(['w']);

/**
 * OTHER USES FOR ROLES AND SCOPE
 * You do not have to restrict the use of roles and scope to just the user context
 * You could set your schema to have roles and scope for different scenarios
 * Examples could be a `preview` scope could be used to refine the fields to select fields for a quick preview of a record
 */

$isotopes = $reactor->with(Press::values([
    'first_name' => 'John',
    'last_name' => 'Doe'
]));

$values = Values::gather($isotopes)->all();

var_dump($values);

/**
 * ADDING CUSTOM POLICIES
 * You can add your own custom policy classes. Just be sure to extend the Fission\Policy\AbstractPolicy abstract class
 * to ensure acceptance by the policy collection classes. Check out the Deny and Allow polices for an example on how policies are created
 */