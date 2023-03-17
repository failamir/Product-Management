<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Purchase extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'purchases';

    protected $appends = [
        'photo',
    ];

    public const STATUS_SELECT = [
        'Active'   => 'Active',
        'InActive' => 'InActive',
    ];

    protected $dates = [
        'purchase_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const PAYMENT_METHOD_SELECT = [
        'Cash'          => 'Cash',
        'Bank Transfer' => 'Bank Transfer',
    ];

    public const UNIT_SELECT = [
        'pcs'     => 'pcs',
        'bottles' => 'bottles',
        'Pack'    => 'Pack',
        'box'     => 'box',
        'Rol'     => 'Rol',
        'sachet'  => 'sachet',
        'Kg'      => 'Kg',
        'Liter'   => 'Liter',
    ];

    protected $fillable = [
        'purchase_code',
        'purchase_date',
        'supplier_id',
        'product_name',
        'quantity',
        'unit',
        'unit_price',
        'discount',
        'sub_total',
        'total_discount',
        'transport_cost',
        'grand_total',
        'total_paid',
        'payment_method',
        'purchase_note',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getPurchaseDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setPurchaseDateAttribute($value)
    {
        $this->attributes['purchase_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function getPhotoAttribute()
    {
        $files = $this->getMedia('photo');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }
}
