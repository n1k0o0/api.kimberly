<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = ['service', 'link', 'social_linkable_type', 'social_linkable_id'];

    public $timestamps = false;

    public function socialLinkable()
    {
        return $this->morphTo();
    }
}
