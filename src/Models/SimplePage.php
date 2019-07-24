<?php
namespace Kurious7\SimplePages\Models;

use Carbon\Carbon;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SimplePage extends Model
{
    use HasSlug,
        SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'show_in_menu',
        'public',
        'public_from',
        'public_until'
    ];

    protected $casts = [
        'public' => 'boolean',
        'show_in_menu' => 'boolean',
    ];

    protected $dates = [
        'public_from',
        'public_until',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('simple-pages.table', 'pages');
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Attributes
     */
    protected function getIsPublicAttribute()
    {
        if ($this->public == 1 ||
            ($this->public_from && $this->public_from < new Carbon()) ||
            ($this->public_until && $this->public_until > new Carbon())
        ) {
            return true;
        }

        return false;
    }

    /**
     * Scopes
     */
    public function scopeVisibleInMenu($query)
    {
        return $query->where('show_in_menu', true);
    }

    public function scopePublished($query)
    {
        return $query->where('public', true)
            ->where(function ($query) {
                $today = (new Carbon)->toDateString();

                $query->where(function ($query) use ($today) {
                    $query->whereDate('public_from', '<=', $today)->orWhereNull('public_from');
                })
                ->where(function ($query) use ($today) {
                    $query->whereDate('public_until', '>=', $today)->orWhereNull('public_until');
                });
            });
    }
}
