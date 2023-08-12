<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsCategory extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'slug',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

     /**
     * @return HasMany
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'news_category_id');
    }
}
