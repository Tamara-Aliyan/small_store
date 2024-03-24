<?php

namespace App\Models\API\V1;

use Illuminate\Database\Eloquent\{
    Builder,
    Factories\HasFactory
};

class Category extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id'
    ];

    // public function products() {
    //     return $this->hasMany(Product::class)->Username();
    // }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function childrens() {
        return $this->hasMany(Category::class, 'parent_id')
            ->select([
                'id',
                'name',
                'parent_id',
                'created_at'
            ])->with(['childrens', 'products.user']);
    }

    public function scopeParent(Builder $builder) {
        $builder->whereNull('parent_id');
    }
}
