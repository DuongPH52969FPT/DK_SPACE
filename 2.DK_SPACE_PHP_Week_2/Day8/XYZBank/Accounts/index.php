<?php
namespace Day8\XYZBank\Accounts;

echo "<h1>Mô-đun: Hệ thống quản lý tài khoản và giao dịch ngân hàng số</h1>";

// 1. Interface chỉ dùng cho tài khoản sinh lãi
interface InterestBearing {
    public function calculateAnnualInterest(): float;
}

// 2. Trait để log giao dịch
trait TransactionLogger {
    public function logTransaction(string $type, float $amount, float $newBalance): void {
        echo "[" . date('Y-m-d H:i:s') . "] $type: $amount VND | Số dư mới: $newBalance <br>" . PHP_EOL;
    }
}

// 3. Abstract class nền tảng
abstract class BankAccount {
    protected $accountNumber;
    protected $ownerName;
    protected $balance;

    const DEFAULT_INTEREST_RATE = 0.05;

    public function __construct(string $accountNumber, string $ownerName, float $balance) {
        $this->accountNumber = $accountNumber;
        $this->ownerName = $ownerName;
        $this->balance = $balance;
        Bank::$totalAccounts++;
    }

    public function getAccountNumber(): string {
        return $this->accountNumber;
    }

    public function getOwnerName(): string {
        return $this->ownerName;
    }

    public function getBalance(): float {
        return $this->balance;
    }

    abstract public function deposit(float $amount): void;
    abstract public function withdraw(float $amount): void;
    abstract public function getAccountType(): string;
}

// 4. Lớp Bank chứa thông tin tĩnh
class Bank {
    public static int $totalAccounts = 0;

    public static function getBankName(): string {
        return "Ngân hàng XYZ";
    }
}

// 5. Tài khoản thanh toán
class CheckingAccount extends BankAccount {
    use TransactionLogger;

    public function deposit(float $amount): void {
        $this->balance += $amount;
        $this->logTransaction("Gửi tiền", $amount, $this->balance);
    }

    public function withdraw(float $amount): void {
        if ($amount > $this->balance) {
            echo "Số dư không đủ để rút!" . PHP_EOL;
            return;
        }
        $this->balance -= $amount;
        $this->logTransaction("Rút tiền", $amount, $this->balance);
    }

    public function getAccountType(): string {
        return "Thanh toán";
    }
}

// 6. Tài khoản tiết kiệm
class SavingsAccount extends BankAccount implements InterestBearing {
    use TransactionLogger;

    public function deposit(float $amount): void {
        $this->balance += $amount;
        $this->logTransaction("Gửi tiền", $amount, $this->balance);
    }

    public function withdraw(float $amount): void {
        if (($this->balance - $amount) < 1000000) {
            echo "Không được rút nếu số dư sau giao dịch < 1.000.000 VNĐ" . PHP_EOL;
            return;
        }
        $this->balance -= $amount;
        $this->logTransaction("Rút tiền", $amount, $this->balance);
    }

    public function getAccountType(): string {
        return "Tiết kiệm";
    }

    public function calculateAnnualInterest(): float {
        return $this->balance * self::DEFAULT_INTEREST_RATE;
    }
}

// 7. Bộ sưu tập tài khoản
class AccountCollection implements \IteratorAggregate {
    private array $accounts = [];

    public function addAccount(BankAccount $account) {
        $this->accounts[] = $account;
    }

    public function getIterator(): \Traversable {
        return new \ArrayIterator($this->accounts);
    }

    public function filterHighBalance(): array {
        return array_filter($this->accounts, fn($acc) => $acc->getBalance() >= 10000000);
    }
}

// ======================
// THỰC THI (main logic)
// ======================

// Tạo tài khoản
$saving = new SavingsAccount('10201122', 'Nguyễn Thị A', 20000000);
$checking1 = new CheckingAccount('20301123', 'Lê Văn B', 8000000);
// $checking2 = new CheckingAccount('20401124', 'Trần Minh C', 12000000);

// Giao dịch
$checking1->deposit(5000000);     // Gửi thêm 5.000.000
// $checking2->withdraw(2000000);    // Rút 2.000.000

// Bộ sưu tập tài khoản
$collection = new AccountCollection();
$collection->addAccount($saving);
$collection->addAccount($checking1);
// $collection->addAccount($checking2);

// Hiển thị thông tin tài khoản
foreach ($collection as $acc) {
    echo "<strong>Tài khoản</strong>: " . $acc->getAccountNumber() . " | " .
         $acc->getOwnerName() . " | " .
         "<strong>Loại</strong>: " . $acc->getAccountType() . " | " .
         "<strong>Số dư</strong>: " . number_format($acc->getBalance()) . "<br>";
}

// Hiển thị lãi suất hàng năm của tài khoản tiết kiệm
echo "<strong>Lãi suất hàng năm cho</strong>: " . $saving->getOwnerName() . ": " .
     number_format($saving->calculateAnnualInterest()) . "<br>";

// Tổng số tài khoản đã tạo
echo "<strong>Tổng số tài khoản đã tạo</strong>: " . Bank::$totalAccounts . "<br>";

// Tên ngân hàng
echo "<strong>Tên ngân hàng:</strong> " . Bank::getBankName();
