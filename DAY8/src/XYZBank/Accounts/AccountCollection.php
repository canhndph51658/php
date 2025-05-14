<?php

namespace XYZBank\Accounts;

use IteratorAggregate;
use ArrayIterator;

/**
 * Class AccountCollection
 * Tập hợp các tài khoản ngân hàng có thể lặp và lọc.
 */
class AccountCollection implements IteratorAggregate
{
    /**
     * @var BankAccount[]
     */
    private array $accounts = [];

    public function addAccount(BankAccount $account): void
    {
        $this->accounts[] = $account;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->accounts);
    }

    /**
     * @param float $minBalance
     * @return BankAccount[]
     */
    public function getHighBalanceAccounts(float $minBalance = 10000000): array
    {
        return array_filter($this->accounts, fn($acc) => $acc->getBalance() >= $minBalance);
    }
}
