<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class EstadoTransaccion extends Enum
{
    const Iniciada =   0;
    const Aceptada =   1;
    const Rechazada = 2;
    const Pendiente = 3;
    const Fallida = 4;
}
