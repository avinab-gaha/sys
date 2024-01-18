<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filebox extends Model
{
    use HasFactory;
    protected $table = 'filebox';
    protected $fillable = ['id', 'ref_table', 'ref_record_id', 'is_main_image', 'filename', 'original_filename', 'mime_type', 'file_extension', 'file_path'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'id');
    }
}
