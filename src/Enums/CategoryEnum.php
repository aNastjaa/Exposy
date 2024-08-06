<?php

namespace Crmlva\Exposy\Enums;

enum CategoryEnum: string
{
    case ContemporaryArt = 'Contemporary Art';
    case HistoricalArt = 'Historical Art';
    case DigitalArt = 'Digital Art';
    case Sculpture = 'Sculpture';

    public static function values(): array
    {
        return array_map(fn($category) => $category->value, self::cases());
    }
}
