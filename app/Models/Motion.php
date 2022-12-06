<?php

namespace App\Models;

use App\Events\MotionCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motion extends Model
{
    use HasFactory;

    protected $fillable = [
        'motion',
    ];

    protected $dispatchesEvents = [
        'created' => MotionCreated::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
