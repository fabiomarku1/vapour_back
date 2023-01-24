<?php
class SalesUpdateDTO {
    public $Id;
    public $Amount;
    public $UserId;
    public $DateCreated;

    function __construct(array $data)
    {
        foreach ($data as $key => $val) {
            if (property_exists(__CLASS__, $key)) {
                $this->$key = $val;
            }
        }
    }

}
