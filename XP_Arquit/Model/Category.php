class Category {
    private $name;
    private $description;
    private $weight;

    public function __construct($name, $description, $weight) {
        $this->name = $name;
        $this->description = $description;
        $this->weight = $weight;
    }

    //! Método Get e Set
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    //!Métodos Específicos
    public function addCategory() {
        //* Terminar de implementar
    }

    public function editCategory($name, $description, $weight) {
        $this->setName($name);
        $this->setDescription($description);
        $this->setWeight($weight);
    }

    public function deleteCategory() {
        //* Terminar de implementar
    }
}