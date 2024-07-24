<?php

namespace Crmlva\Exposy\Enums;

class CountryEnum
{
    public const GERMANY = 'Germany';
    public const AUSTRIA = 'Austria';
    public const BELGIUM = 'Belgium';
    public const CZECH_REPUBLIC = 'Czech Republic';
    public const DENMARK = 'Denmark';
    public const FRANCE = 'France';
    public const HUNGARY = 'Hungary';
    public const ITALY = 'Italy';
    public const LUXEMBOURG = 'Luxembourg';
    public const NETHERLANDS = 'Netherlands';
    public const POLAND = 'Poland';
    public const SLOVAKIA = 'Slovakia';
    public const SWITZERLAND = 'Switzerland';
    public const LIECHTENSTEIN = 'Liechtenstein';
    public const SLOVENIA = 'Slovenia';
    public const CROATIA = 'Croatia';

    public static function getAll(): array
    {
        return [
            self::GERMANY,
            self::AUSTRIA,
            self::BELGIUM,
            self::CZECH_REPUBLIC,
            self::DENMARK,
            self::FRANCE,
            self::HUNGARY,
            self::ITALY,
            self::LUXEMBOURG,
            self::NETHERLANDS,
            self::POLAND,
            self::SLOVAKIA,
            self::SWITZERLAND,
            self::LIECHTENSTEIN,
            self::SLOVENIA,
            self::CROATIA
        ];
    }
}
