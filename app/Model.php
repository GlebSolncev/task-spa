<?php


class Model
{
    protected $table;
    protected $columns;
    protected $db;

    public function __construct()
    {
        $this->db = new DB;
    }

    /**
     * @return $this
     */
    public function all()
    {
        $data = $this->db->select("select * from " . $this->table);
        foreach ($data as $key => $item):
            $name_class = get_called_class();
            $class = new $name_class;

            foreach ($item as $name => $value):
                $class->$name = $value;
            endforeach;

            $return[] = $class;
        endforeach;
        return $return;
    }

    public function orderby($data)
    {
        $key = key($data);
        $value = $data[$key];

        $data = $this->db->select("select * from {$this->table} order by {$key} {$value};");

        foreach ($data as $key => $item):
            $name_class = get_called_class();
            $class = new $name_class;

            foreach ($item as $name => $value):
                $class->$name = $value;
            endforeach;

            $return[] = $class;
        endforeach;
        return $return;
    }

    public function insert($value)
    {
        $values = '"' . implode('","', $value) . '"';
        $return_id = $this->db->insert_with_return_id("insert into {$this->table} values (null, {$values})");
        return $return_id;
    }

    public function update($id, $value)
    {
        array_walk($value, create_function('&$i,$k', '$i=" $k=\"$i\"";'));
        $values = implode($value, ",");

        $this->db->update("update {$this->table} set {$values}  where id = {$id}");
        return 1;
    }

}