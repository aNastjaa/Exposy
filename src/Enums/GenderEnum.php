<?php

namespace Crmlva\Exposy\Enums;

class GenderEnum
{
    public const MALE = 'Male';
    public const FEMALE = 'Female';
    public const DIVERSE = 'Diverse';

    public static function getAll(): array
    {
        return [
            self::MALE,
            self::FEMALE,
            self::DIVERSE
        ];
    }
}
