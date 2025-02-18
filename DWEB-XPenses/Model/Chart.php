<?php    
    class Chart {
        private $month;

        public function __construct($month) {
            $this->month = $month;
        }

        //! Métodos Get e Set
        public function getMonth() {
            return $this->month;
        }

        public function setMonth($month) {
            $this->month = $month;
        }

        //! Métodos Especificos
        public function generateByCategory() {
            //* Terminar de implementar
        }

        public function generateByValueRange() {
            //* Terminar de implementar
        }
    }
?>
