<?php

namespace App\Models;

use App\Models\User;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model implements HasMedia
{
    use HasFactory ,InteractsWithMedia;

    protected $fillable = [
        'title' , 'description' , 'start_date' , 'deadline' , 'priority' , 'status' , 'images' , 'files'
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'images' => 'array',
        'files' => 'array',
    ];

    /**
     * The leaders that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function leaders(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'projec_leaders' , 'project_id', 'user_id');
    }

     /**
     * The roles that belong to the ProjectMember
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members' , 'project_id', 'user_id');
    }
}
