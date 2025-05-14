<?php

namespace XYZBank\Accounts;

/**
 * Class Bank
 * Lớp tiện ích quản lý thông tin hệ thống ngân hàng.
 */
class Bank
{
    private static int $totalAccounts = 0;

    public static function incrementTotalAccounts(): void
    {
        self::$totalAccounts++;
    }

    public static function getTotalAccounts(): int
    {
        return self::$totalAccounts;
    }

    public static function getBankName(): string
    {
        return 'Ngân hàng XYZ';
    }
}
