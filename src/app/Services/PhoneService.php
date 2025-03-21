<?php

namespace App\Services;

use libphonenumber\PhoneNumberUtil;
use Throwable;

class PhoneService
{
    private PhoneNumberUtil $phoneUtil;
    public function __construct()
    {
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    public function formatPhone(string $phone): string
    {
        $cleaned = preg_replace('/[^\d+]/', '', $phone);
        $cleaned = preg_replace('/^\++/', '+', $cleaned);

        return str_starts_with($cleaned, '+') ? $cleaned : "+$cleaned";
    }

    public function getRegionCode(string $phone): ?string
    {
        try {
            return $this->phoneUtil->getRegionCodeForNumber(
                $this->phoneUtil->parse($phone)
            );
        } catch (Throwable) {
            return null;
        }

    }


}
