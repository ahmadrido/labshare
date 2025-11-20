<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class files extends Model
{
    /** @use HasFactory<\Database\Factories\FilesFactory> */
    use HasFactory;
    protected $fillable = [
        'subject_id',
        'user_id',
        'title',
        'file_type',
        'file_path',
        'description',
    ];

    public function downloads()
    {
        return $this->hasMany(downloads::class, 'file_id');
    }

    public function subject()
    {
        return $this->belongsTo(subjects::class, 'subject_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
