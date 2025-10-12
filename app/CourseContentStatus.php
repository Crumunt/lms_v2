<?php

namespace App;

enum CourseContentStatus: string
{
    //
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}
