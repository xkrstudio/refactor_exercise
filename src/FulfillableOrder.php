<?php
class FulfillableOrder {
    private array $headerList = [];
    private array $orderList = [];
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

    public function readOrderList() : void {
        $row = 1;
        if (($handle = fopen('orders.csv', 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                if ($row == 1) {
                    $this->headerList = $data;
                } else {
                    $order = [];
                    for ($i = 0; $i < count($this->headerList); $i++) {
                        $order[$this->headerList[$i]] = $data[$i];
                    }
                    $this->orderList[] = $order;
                }
                $row++;
            }
            fclose($handle);
        }
    }
    
}
?>
