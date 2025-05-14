<?php

namespace XYZBank\Accounts;

/**
 * Class SavingsAccount
 * Tài khoản tiết kiệm có tính lãi suất và hạn chế rút.
 */
class SavingsAccount extends BankAccount implements InterestBearing
{
    use TransactionLogger;

    private const INTEREST_RATE = 0.05;

    public function deposit(float $amount): void
    {
        $this->balance += $amount;
        $this->logTransaction('Gửi tiền', $amount, $this->balance);
    }

    public function withdraw(float $amount): void
    {
        if ($this->balance - $amount < 1000000) {
            echo "Không thể rút. Số dư sau rút phải ≥ 1.000.000 VNĐ\n";
            return;
        }

        $this->balance -= $amount;
        $this->logTransaction('Rút tiền', $amount, $this->balance);
    }

    public function calculateAnnualInterest(): float
    {
        return $this->balance * self::INTEREST_RATE;
    }

    public function getAccountType(): string
    {
        return "Tiết kiệm";
    }
}
