<?php

namespace XYZBank\Accounts;

/**
 * Interface InterestBearing
 * Cho tài khoản có thể tính lãi suất hàng năm.
 */
interface InterestBearing
{
    public function calculateAnnualInterest(): float;
}
