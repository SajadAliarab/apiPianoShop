<?php
namespace App\Enums;

enum ProductStatusEnum: string
{
    case New = 'new';
    case Used = 'used';
    case Discountinued = 'discountinued';
}
