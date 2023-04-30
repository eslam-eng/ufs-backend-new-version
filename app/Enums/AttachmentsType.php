<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum AttachmentsType: int
{
    use Options, Values,InvokableCases;

    case PRIMARYIMAGE = 1;
    case ATTACHMENT = 2;
}
