<?php

namespace App\Enums;

/**
 * Shared by user-submitted content that admins moderate
 * (testimonials, blog comments).
 */
enum ModerationStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}
