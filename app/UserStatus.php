<?php

namespace App;

enum UserStatus:string
{
    //
    case pending = 'pending';
    case active = 'active';
    case inactive = 'inactive';
    case deactivated = 'deactivated';
}
