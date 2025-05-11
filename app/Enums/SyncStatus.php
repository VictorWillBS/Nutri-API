<?php

namespace App\Enums;

enum SyncStatus: string
{
    case Started = 'started';
    case NotStarted = 'not_started';
    case Canceled = 'canceled';
    case Completed = 'completed';
    case Downloaded = 'downloaded';
    case Ready = 'ready';
    case Processing = 'processing';
}
