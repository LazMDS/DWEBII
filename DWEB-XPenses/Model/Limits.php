<?php
    class Limit {
        private $month;
        private $amount;
        private $category;

        public function __construct($month, $amount, $category) {
            $this->month = $month;
            $this->amount = $amount;
            $this->category = $category;
        }

        //! Métodos Get e Set
        public function getMonth() {
            return $this->month;
        }

        public function setMonth($month) {
            $this->month = $month;
        }

        public function getAmount() {
            return $this->amount;
        }

        public function setAmount($amount) {
            $this->amount = $amount;
        }

        public function getCategory() {
            return $this->category;
        }

        public function setCategory($category) {
            $this->category = $category;
        }

        //! Métodos Especificos
        public function addLimit() {
            //* Terminar de implementar
        }

        public function editLimit($amount, $category) {
            $this->setAmount($amount);
            $this->setCategory($category);
        }

        public function deleteLimit() {
            //* Terminar de implementar
        }
    }
?>
