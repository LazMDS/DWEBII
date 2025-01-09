class Dashboard {
    private $month;
    private $totalExpenses;
    private $remainingBalance;

    public function __construct($month, $totalExpenses, $remainingBalance) {
        $this->month = $month;
        $this->totalExpenses = $totalExpenses;
        $this->remainingBalance = $remainingBalance;
    }

    //! Métodos Get e Set
    public function getMonth() {
        return $this->month;
    }

    public function setMonth($month) {
        $this->month = $month;
    }

    public function getTotalExpenses() {
        return $this->totalExpenses;
    }

    public function setTotalExpenses($totalExpenses) {
        $this->totalExpenses = $totalExpenses;
    }

    public function getRemainingBalance() {
        return $this->remainingBalance;
    }

    public function setRemainingBalance($remainingBalance) {
        $this->remainingBalance = $remainingBalance;
    }

    //! Métodos Especificos
    public function updateDashboard() {
        //* Terminar de implementar
    }
}
