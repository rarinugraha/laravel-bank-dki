<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'place_of_birth',
        'birth_date',
        'gender',
        'occupation_id',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'address',
        'rt',
        'rw',
        'deposit',
        'status',
        'email_sent_status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getBirthDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public static function relationshipNames()
    {
        return [
            'occupation',
            'province',
            'regency',
            'district',
            'village',
            'creator',
            'updater',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
                $model->updated_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }
}
