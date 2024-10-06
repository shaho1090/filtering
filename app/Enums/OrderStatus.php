<?php

namespace App\Enums;

use App\Traits\Enums\EnumToArrayTrait;

enum OrderStatus: string
{
    use EnumToArrayTrait;

    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case APPROVED = 'approved';
    case COMPLETED = 'completed';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';
    case DELIVERED = 'delivered';
}
