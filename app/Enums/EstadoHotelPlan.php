<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class EstadoHotelPlan extends Enum
{
    const activo =   1;
    const inactivo =   2;
    const demo = 3;
    const mora = 4;
}
