<?php

namespace App\Traits;

trait RouteForSms
{
    public function routeNotificationForSms($driver, $notification = null)
    {
        return $this->mobile;
    }
}
