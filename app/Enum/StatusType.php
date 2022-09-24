<?php

namespace App\Enum;

enum StatusType: int
{
    case DRAFT        = 0;
    case PLANNING     = 1;
    case IN_PROGRESS  = 2;
    case CLOSED       = 3;
    case HOLD         = 4;
}