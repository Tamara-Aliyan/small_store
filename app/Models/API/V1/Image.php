<?php

namespace App\Models\API\V1;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model
};

class Image extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'image_name',
    ];

    public function imageable() {
        return $this->morphTo();
    }
}
