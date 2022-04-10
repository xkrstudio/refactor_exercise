<?php
class FulfillableOrder {

    public function checkParameter(int $parameter) : void {
        if ($parameter != 2) {
            echo 'Ambiguous number of parameters!';
            exit(1);
        }
    }
    
}
?>