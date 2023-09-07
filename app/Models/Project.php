<?php

namespace App\Models;

use App\Enums\ProjectStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Felhasználó projektjei
 */
class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'note', 'status'];

    protected $casts = [
        'status' => ProjectStatusEnum::class
    ];

    /**
     * Project's creator
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Project's members
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projectMember()
    {
        return $this->hasMany(ProjectMember::class);
    }

    /**
     * Filter: status
     * @param $status
     * @return void
     */
    public function scopeStatus($query, $status)
    {
        if(empty($status)) {
            return $query;
        }

        return $query->where('status', $status);
    }


    // Note: PHP 8.1 new keywords
    /*
    public function members(): Attribute
    {
         return Attribute::make(
            get: fn ($value) => $this->projectMember->count()
        );
    }
*/

}
