<?php

namespace App\Enums;

use Illuminate\Support\Traits\EnumeratesValues;

enum ProjectStatusEnum:string {

    case WAITING    = 'waiting';
    case INPROGRESS = "inprogress";
    case SUCCESS    = "success";

    public function getName():string
    {
        return match($this) {
            self::WAITING => __("waiting"),
            self::INPROGRESS => __("in progress"),
            self::SUCCESS => __("success"),
            default => null
        };
    }

    public static function toArray($withAll=false)
    {

        $r = $withAll ? ['' => __('all')] : [];
        foreach (self::cases() as $status) {
            $r[$status->name] = __($status->getName());
        }
        return $r;
    }


}
