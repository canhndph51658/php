<?php

namespace XYZBank\Accounts;

/**
 * Class CheckingAccount
 * Tài khoản thanh toán không có lãi và không giới hạn số dư tối thiểu.
 */
class CheckingAccount extends BankAccount
{
    use TransactionLogger;

    public function deposit(float $amount): void
    {
        $this->balance += $amount;
        $this->logTransaction('Gửi tiền', $amount, $this->balance);
    }

    public function withdraw(float $amount): void
    {
        $this->balance -= $amount;
        $this->logTransaction('Rút tiền', $amount, $this->balance);
    }

    public function getAccountType(): string
    {
        return "Thanh toán";
    }
}
