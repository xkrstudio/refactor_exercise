<?php
class FulfillableOrder {
    private ?object $stock;

    public function checkParameter(int $parameter) : void {
        if ($parameter != 2) {
            echo 'Ambiguous number of parameters!';
            exit(1);
        }
    }

    public function validateJSON(string $json) : void {
        if (($this->stock = json_decode($json)) == null) {
            echo 'Invalid json!';
            exit(1);
        }
    }
    
}
?>
