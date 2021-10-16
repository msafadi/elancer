<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'parent_id', 'slug', 'description', 'art_path',
    ];

    // protected $guarded = [];

    protected $perPage = 2;

    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')
            ->withDefault([
                'name' => 'No Parent'
            ]);
    }
}
