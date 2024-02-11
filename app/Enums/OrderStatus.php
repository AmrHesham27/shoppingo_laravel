<?php

namespace App\Enums;

enum StatusEnum: string {  
    case PENDING = 'pending';
    case RECIEVED = 'recieved';
    case CANCELED = 'canceled';
}