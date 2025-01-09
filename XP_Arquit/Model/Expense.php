class Expense {
    private $description;
    private $category;
    private $amount;
    private $date;

    public function __construct($description, $category, $amount, $date) {
        $this->description = $description;
        $this->category = $category;
        $this->amount = $amount;
        $this->date = $date;
    }

    //! Métodos Get e Set
    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    //! Métodos Especificos
    public function addExpense() {
        //* Terminar de implementar
    }

    public function editExpense($description, $category, $amount) {
        $this->setDescription($description);
        $this->setCategory($category);
        $this->setAmount($amount);
    }

    public function deleteExpense() {
        //* Terminar de implementar
    }
}
