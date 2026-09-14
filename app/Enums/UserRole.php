<?php

namespace App\Enums;

enum UserRole: string
{
    case MEMBER = 'member';
    case ADMIN = 'admin';
}
