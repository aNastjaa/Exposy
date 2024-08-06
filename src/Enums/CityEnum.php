<?php

namespace Crmlva\Exposy\Enums;

enum CityEnum: string
{
    case Berlin = 'Berlin';
    case Bremen = 'Bremen';
    case Cologne = 'Cologne';
    case Duisburg = 'Duisburg';
    case Düsseldorf = 'Düsseldorf';
    case Essen = 'Essen';
    case Frankfurt = 'Frankfurt';
    case Freiburg = 'Freiburg';
    case Hamburg = 'Hamburg';
    case Hanover = 'Hanover';
    case Karlsruhe = 'Karlsruhe';
    case Munich = 'Munich';
    case Nuremberg = 'Nuremberg';
    case Potsdam = 'Potsdam';
    case Stuttgart = 'Stuttgart';
    case Wuppertal = 'Wuppertal';

public static function values(): array
    {
        return array_map(fn($city) => $city->value, self::cases());
    }
}