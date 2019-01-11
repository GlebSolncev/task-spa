<?php
$table = "product";
try {
    $db = new DB();
    $db->setAttribute(DB::ATTR_ERRMODE, DB::ERRMODE_EXCEPTION);

    if (USE_CREATE_TABLE) {
        $sql = "CREATE table IF NOT EXISTS $table(
                 id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                 name VARCHAR( 255 ) NOT NULL, 
                 description TEXT NOT NULL,
                 price FLOAT NOT NULL, 
                 status BOOLEAN NOT NULL DEFAULT '0'
                 )";
        $db->exec($sql);
        $logger[] = "Таблица: $table создана.";
    }
    if (INSER_VALUES) {

        $array = [
            [
                'id' => 1,
                'name' => 'A',
                'description' => 'Desc - A',
                'price' => 100,
                'status' => 1,
            ],
            [
                'id' => 2,
                'name' => 'B',
                'description' => 'Desc - B',
                'price' => 200,
                'status' => 1,
            ],
            [
                'id' => 3,
                'name' => 'C',
                'description' => "Desc - C",
                'price' => 300,
                'status' => 0,
            ]
        ];
        foreach ($array as $item) {
            $select = "select count(*) count from {$table} where id = {$item['id']}";
            $count = $db->query($select)->fetchColumn();
            $result[] = ['count' => $count, 'id' => $item['id']];
            if (!$count) {
                $sql = "insert into {$table} values({$item['id']}, '{$item['name']}', '{$item['description']}', '{$item['price']}', {$item['status']} );";

                $stmt = $db->prepare($sql);
                $stmt->execute();
                $logger[] =  $item['id'].$item['name']." - Добавлен!";
            }else{
                $logger[] =  $item['id'].$item['name']." - Существует!";
            }
        }
    }
} catch (PDOException $e) {
    $logger[] = $e->getMessage();
}

