<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class downloads extends Model
{
    /** @use HasFactory<\Database\Factories\DownloadsFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'file_id',
    ];

        public function file()
    {
        return $this->belongsTo(files::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
