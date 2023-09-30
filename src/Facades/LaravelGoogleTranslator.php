<?php

namespace Webtamizhan\LaravelGoogleTranslator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Webtamizhan\LaravelGoogleTranslator\LaravelGoogleTranslator
 */
class LaravelGoogleTranslator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Webtamizhan\LaravelGoogleTranslator\LaravelGoogleTranslator::class;
    }
}
