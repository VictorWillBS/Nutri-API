<?php

namespace App\Enums\Products;

enum ProductStatus: string
{
    case Draft = 'draft';
    case Trashed = 'trash';
    case Published = 'published';
}
