<?php

namespace App\Enums;

enum ProductStatus: string
{
    case Draft = 'draft';
    case Trashed = 'trashed';
    case Published = 'published';
}
