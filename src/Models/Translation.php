<?php

namespace Webtamizhan\LaravelGoogleTranslator\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Translation extends Model
{

    protected $table = config('google-translator.table_name','translations');

    /**
     * @var mixed|string
     */
    public mixed $translated_column_value;
    protected $fillable = [
         "lang","model_name","model_id", "column_name", "translated_column_value"
    ];


}
