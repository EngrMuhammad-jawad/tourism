<?php

namespace App\Models;

use App\Enums\ModerationStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['user_id', 'name', 'country', 'rating', 'content', 'status'])]
class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'status' => ModerationStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    #[Scope]
    protected function approved(Builder $query): void
    {
        $query->where('status', ModerationStatus::Approved);
    }
}
