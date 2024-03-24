<?php

namespace App\Models\API\V1;

use Illuminate\Database\Eloquent\{
    Builder,
    Factories\HasFactory
};

class Product extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'name',
        'price',
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeUsername( Builder $builder ) {
        $builder->whereRelation('user', 'name', 'like', '%a%');
    }

    // protected static function booted()
    // {
    //     static::addGlobalScope('check_price', function ($query) {
    //         $query->where('price', '>=', 150);
    //     });
    // }

    public function createManyImages($images) {
        foreach($images as $image) {
            $this->images()->create(['image_name' => $image]);
        }
    }

}
