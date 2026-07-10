<?php

namespace App\Models;

use App\Enums\ModerationStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['post_id', 'user_id', 'parent_id', 'name', 'email', 'body', 'status'])]
class Comment extends Model
{
    protected function casts(): array
    {
        return [
            'status' => ModerationStatus::class,
        ];
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Display name works for both guest and registered commenters.
     */
    public function displayName(): string
    {
        return $this->user?->name ?? $this->name ?? __('guest');
    }

    #[Scope]
    protected function approved(Builder $query): void
    {
        $query->where('status', ModerationStatus::Approved);
    }
}
