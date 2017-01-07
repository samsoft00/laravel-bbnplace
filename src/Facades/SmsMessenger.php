<?php
/**
 * Created by PhpStorm.
 * User: WF-INNOVATION
 * Date: 1/7/2017
 * Time: 3:04 AM
 */

namespace Samsoft00\Bbnplace\Facades;


use Illuminate\Support\Facades\Facade;

class SmsMessenger extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-bbnplace';
    }

}