<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasarelaPago extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pag_dig_Respuesta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'cardType',
        'bin',
        'lastDigits',
        'deferredCode',
        'deferred',
        'cardBrandCode',
        'cardBrand',
        'amount',
        'clientTransactionId',
        'phoneNumber',
        'statusCode',
        'transactionStatus',
        'messageCode',
        'transactionId',
        'document',
        'currency',
        'optionalParameter1',
        'optionalParameter2',
        'optionalParameter3',
        'optionalParameter4',
        'storeName',
        'date',
        'regionIso',
        'transactionType',
        'reference',
        'payphone',
    ];

    public $timestamps = false;
}
