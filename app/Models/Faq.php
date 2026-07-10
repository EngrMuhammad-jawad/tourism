<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

#[Fillable(['question', 'answer', 'sort_order', 'status'])]
class Faq extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    /** @var array<int, string> Translatable (JSON) attributes. */
    public array $translatable = ['question', 'answer'];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', true)->orderBy('sort_order');
    }
}
