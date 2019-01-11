<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10.01.2019
 * Time: 22:41
 */
namespace Controller;

use Model\Product;

class ProductController
{
    protected $model;
    protected $csrf_token;

    public function __construct()
    {
        $this->model = new Product;
        if (!empty($_POST['token'])) {
            if (hash_equals($_SESSION['token'], $_POST['token'])) {
                $this->csrf_token = true;
            } else {
                $this->csrf_token = false;
                dd('Ошибка! CRSF TOKEN валидация не правильная! Повторите попытку или уберите условие');
            }
        }
    }

    public function index()
    {
        if(isset($_GET) and $_GET['orderby']){
            return $this->orderby();
        }

        $args = $this->model->all();
        return view($_SERVER['DOCUMENT_ROOT'].'/resource/product/index.php', compact('args'));
    }

    public function add()
    {
        if($this->csrf_token) {
            $data = request_field($_POST, ['name', 'description', 'price', 'status']);
            if($this->insert($data))
                return $this->index();
        }
        return null;
    }

    public function insert($input)
    {
        if($this->model->insert($input)) {
            return $this->index();
        }
        dd('Добавление не сработало');
        return null;
    }

    public function update()
    {
        if($this->csrf_token) {
            $id = $_POST['id'];
            $data = request_field($_POST, ['name', 'description', 'price', 'status']);
            $this->model->update($id, $data);
            return $this->index();
        }
        return null;
    }

    public function setStatus()
    {

        if($this->csrf_token) {
            $id = $_POST['id'];
            $data = request_field($_POST, ['status']);
            $return = $this->model->update($id, $data);

            if($return)
                return $this->index();
        }
        return null;
    }

    public function orderby()
    {
        $order = $_GET['orderby'];
        $by = explode(':', $order, 2); 
        $args = $this->model->orderby($by[0], $by[1]);
        return view($_SERVER['DOCUMENT_ROOT'].'/resource/product/index.php', compact('args'));
    }
}