<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Projekt kapcsolttartó
 */
class ProjectMember extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    /**
     * Kapcsolattartó projektje
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
