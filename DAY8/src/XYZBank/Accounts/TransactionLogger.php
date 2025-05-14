<?php
namespace XYZBank\Accounts;

trait TransactionLogger
{
    protected array $logs = [];

    public function logTransaction(string $type, float $amount, float $newBalance): void
    {
        $logEntry = sprintf(
            "[%s] Giao dịch: %s %s VNĐ | Số dư mới: %s VNĐ",
            date('Y-m-d H:i:s'),
            $type,
            number_format($amount, 0, ',', '.'),
            number_format($newBalance, 0, ',', '.')
        );
        $this->logs[] = $logEntry;
    }

    public function getLogs(): array
    {
        return $this->logs;
    }
}
