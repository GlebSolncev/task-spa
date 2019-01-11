<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10.01.2019
 * Time: 22:24
 */

namespace Model;

use Model;

class Product extends Model
{
    protected $table = "product";
    public $id;
    public $name;
    public $description;
    public $price;
    public $status;

    public function status()
    {
        $text = null;
        if ($this->status == 1) {
            $text = "Активный";
        } else {
            $text = "Удален";
        }
        return $text;
    }

}