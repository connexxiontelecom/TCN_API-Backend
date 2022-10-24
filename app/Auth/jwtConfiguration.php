<?php

namespace App\Auth;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;


$configuration = Configuration::forSymmetricSigner(
// You may use any HMAC variations (256, 384, and 512)
    new Sha256(),
    // replace the value below with a key of your own!
    InMemory::plainText('!@pass?')
// You may also override the JOSE encoder/decoder if needed by providing extra arguments here
);

