<?php

namespace App\Models;

use App\Utils\TimeZoneHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;


/**
 * App\Models\Account
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $street
 * @property string|null $city
 * @property string|null $state
 * @property string|null $country
 * @property string|null $post_code
 * @property string|null $stripe_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|Contact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read mixed $full_address
 * @property-read Collection|Opportunity[] $opportunities
 * @property-read int|null $opportunities_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static Builder|Account filter(array $filters)
 * @method static Builder|Account newModelQuery()
 * @method static Builder|Account newQuery()
 * @method static Builder|Account onlyTrashed()
 * @method static Builder|Account query()
 * @method static Builder|Account whereCity($value)
 * @method static Builder|Account whereCountry($value)
 * @method static Builder|Account whereCreatedAt($value)
 * @method static Builder|Account whereDeletedAt($value)
 * @method static Builder|Account whereEmail($value)
 * @method static Builder|Account whereId($value)
 * @method static Builder|Account whereName($value)
 * @method static Builder|Account wherePhone($value)
 * @method static Builder|Account wherePostCode($value)
 * @method static Builder|Account whereState($value)
 * @method static Builder|Account whereStreet($value)
 * @method static Builder|Account whereUpdatedAt($value)
 * @method static Builder|Account whereUserId($value)
 * @method static Builder|Account withTrashed()
 * @method static Builder|Account withoutTrashed()
 * @mixin Builder
 */
class Account extends Model
{
    use SoftDeletes, HasFactory;

    protected $appends = ['full_address'];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'street',
        'city',
        'state',
        'country',
        'post_code',
        'user_id'
    ];

    /**
     * @return BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

//    /**
//     * @return HasMany
//     */
//    public function contacts(): HasMany
//    {
//        return $this->hasMany(Contact::class);
//    }

    /**
     * @return HasMany
     */
    public function opportunities(): HasMany
    {
        return $this->hasMany(Opportunity::class);
    }

    public function getFullAddressAttribute()
    {
        return $this->attributes['full_address'] = "{$this->street} {$this->city} {$this->state} {$this->post_code}
        {$this->country}";
    }

    public function getCreatedAtAttribute($value)
    {
        return (new TimeZoneHelper())->formatDate($value);
    }

//    public function setUserIdAttribute()
//    {
//        $this->attributes['user_id'] = Auth::user()->id;
//    }


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        });
    }
}
