<?php

namespace App\Models\API\V1;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model
};

class BaseModel extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ['created_from', 'images'];

    // morphs relation with images table
    public function images() {
        return $this->morphMany(Image::class, 'imageable');
    }

    // created from attribute
    public function getCreatedFromAttribute() {
        return $this->created_at->diffForHumans();
    }

    // images attribute
    public function getImagesAttribute() {
        return $this->images()
            ->get(['imageable_type', 'image_name'])
            ->map(function($image) {
                $dir = explode('\\', $image->imageable_type)[4];
                unset($image->imageable_type);
                return asset("public/$dir") . '/' . $image->image_name;
            });
    }
    
}
