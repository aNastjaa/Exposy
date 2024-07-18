<?php

namespace Crmlva\Exposy;

abstract class Util {

    public static function hashPassword( $password ) {
        
        return password_hash( $password, PASSWORD_DEFAULT );
    }

}