<?php

namespace App\Models\Pdw;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Kjmtrue\VietnamZone\Models\Province
 *
 * @property int $id
 * @property string $name
 * @property string $gso_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Kjmtrue\VietnamZone\Models\District[] $districts
 * @property-read int|null $districts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Province query()
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereGsoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Province extends Model
{
    protected $table = 'provinces';

    protected $fillable = [
        'name',
        'code',
        'gso_id',
        'published',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function districts()
    {
        return $this->hasMany(District::class,  'province_id');
    }

    public static function getAll(){
        return Cache::remember('provinces',60*24*365,function(){
            return self::get()->keyBy('id');
        });
    }
}
