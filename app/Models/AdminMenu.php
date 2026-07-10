<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

#[Fillable(['parent_id', 'title', 'route', 'icon', 'permission_name', 'sort_order', 'status'])]
class AdminMenu extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Sidebar tree for a user: active items only, filtered by the
     * item's permission (Super Admin sees everything via Gate::before).
     */
    public static function sidebarFor(User $user): Collection
    {
        return static::query()
            ->whereNull('parent_id')
            ->where('status', true)
            ->with(['children' => fn ($q) => $q->where('status', true)])
            ->orderBy('sort_order')
            ->get()
            ->map(function (self $item) use ($user) {
                $item->setRelation(
                    'children',
                    $item->children->filter(fn (self $child) => $child->isVisibleTo($user))->values()
                );

                return $item;
            })
            ->filter(fn (self $item) => $item->isVisibleTo($user) && ($item->route || $item->children->isNotEmpty()))
            ->values();
    }

    public function isVisibleTo(User $user): bool
    {
        return ! $this->permission_name || $user->can($this->permission_name);
    }
}
