<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Model_ConfiguracionTienda extends Model
{
    protected $table = 'store_settings';

    protected $fillable = [
        'store_name',
        'logo_path',
        'banner_path',
        'currency_code',
    ];

    protected function currencySymbol(): Attribute
    {
        return Attribute::get(
            fn (): string => $this->currency_code === 'PEN' ? 'S/' : '$'
        );
    }
}
