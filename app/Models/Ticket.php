<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'reporter_id',
        'category_id',
        'title',
        'location',
        'description',
        'urgency',
        'status',
        'resolution_note',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function logs()
    {
        return $this->hasMany(TicketLog::class);
    }

    public function getRouteKeyName()
    {
        return 'code';
    }
}