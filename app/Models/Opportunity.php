<?php

namespace App\Models;

use App\Utils\TimeZoneHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Opportunity
 *
 * @property int $id
 * @property string $name
 * @property int $account_id
 * @property string $sales_stage
 * @property float $amount
 * @property string|null $type
 * @property int $referral_percentage
 * @property float $referral_amount
 * @property string $referral_start_date
 * @property int $created_by
 * @property string|null $sale_start
 * @property string|null $sale_end
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Account $account
 * @method static Builder|Opportunity filter(array $filters)
 * @method static Builder|Opportunity newModelQuery()
 * @method static Builder|Opportunity newQuery()
 * @method static Builder|Opportunity query()
 * @method static Builder|Opportunity whereAccountId($value)
 * @method static Builder|Opportunity whereProductId($value)
 * @method static Builder|Opportunity whereAmount($value)
 * @method static Builder|Opportunity whereCreatedAt($value)
 * @method static Builder|Opportunity whereCreatedBy($value)
 * @method static Builder|Opportunity whereDeletedAt($value)
 * @method static Builder|Opportunity whereId($value)
 * @method static Builder|Opportunity whereName($value)
 * @method static Builder|Opportunity whereReferralAmount($value)
 * @method static Builder|Opportunity whereReferralPercentage($value)
 * @method static Builder|Opportunity whereReferralStartDate($value)
 * @method static Builder|Opportunity whereSaleEnd($value)
 * @method static Builder|Opportunity whereSaleStart($value)
 * @method static Builder|Opportunity whereSalesStage($value)
 * @method static Builder|Opportunity whereType($value)
 * @method static Builder|Opportunity whereUpdatedAt($value)
 * @mixin Builder
 * @property int|null $product_id
 * @property-read mixed $sales_stage_string
 *
 */
class Opportunity extends Model
{
    use HasFactory;

    protected $appends = ['sales_stage_string'];

    protected $fillable = [
        'name',
        'account_id',
        'sales_stage',
        'amount',
        'referral_percentage',
        'referral_amount',
        'referral_start_date',
        'sale_start',
        'sale_end',
        'created_by',
    ];

    const STAGE_PROSPECTING = 1;
    const STAGE_INVESTIGATION = 2;
    const STAGE_PROPOSAL_MADE = 3;
    const STAGE_NEGOTIATION = 4;
    const STAGE_CLOSED_WON = 5;
    const STAGE_CLOSED_LOST = 6;

    const STAGE_PROSPECTING_STRING = "Prospecting";
    const STAGE_INVESTIGATION_STRING = "Investigation";
    const STAGE_PROPOSAL_MADE_STRING = "Proposal Made";
    const STAGE_NEGOTIATION_STRING = "Negotiation";
    const STAGE_CLOSED_WON_STRING = "Closed Won";
    const STAGE_CLOSED_LOST_STRING = "Closed Lost";


    /**
     * @return array[]
     */
    public static function salesStages(): array
    {
        return[
            ['value' => self::STAGE_PROSPECTING, 'label' => self::STAGE_PROSPECTING_STRING],
            ['value' => self::STAGE_INVESTIGATION, 'label' => self::STAGE_INVESTIGATION_STRING],
            ['value' => self::STAGE_PROPOSAL_MADE, 'label' => self::STAGE_PROPOSAL_MADE_STRING],
            ['value' => self::STAGE_NEGOTIATION, 'label' => self::STAGE_NEGOTIATION_STRING],
            ['value' => self::STAGE_CLOSED_WON, 'label' => self::STAGE_CLOSED_WON_STRING],
            ['value' => self::STAGE_CLOSED_LOST, 'label' => self::STAGE_CLOSED_LOST_STRING]
        ];
    }

    /**
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @return int|mixed
     */
    public function getSalesStageStringAttribute()
    {
        return $this->attributes['sales_stage_string'] = self::getSalesStagesSimple($this->sales_stage);
    }

    /**
     * @param $saleStageId
     * @return int|mixed
     */
    public static function getSalesStagesSimple($saleStageId)
    {
        foreach (self::salesStages() as $stage){
            if($stage['value'] == $saleStageId){
                return $stage['label'];
            }
        }
        return self::STAGE_PROSPECTING;
    }

    /**
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return (new TimeZoneHelper())->formatDate($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getReferralStartDateAttribute($value)
    {
        return (new TimeZoneHelper())->formatDate($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getSaleStartAttribute($value)
    {
        return (new TimeZoneHelper())->formatDate($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getSaleEndAttribute($value)
    {
        return (new TimeZoneHelper())->formatDate($value);
    }

    /**
     * @param $query
     * @param array $filters
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
