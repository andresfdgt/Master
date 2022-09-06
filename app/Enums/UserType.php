<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserType extends Enum
{
    const pastor =   1;
    const anciano =   2;
    const diacono = 3;
    const lider_celula = 4;
    const lider_ministerio = 5;
}
