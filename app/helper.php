<?php
/**
 *
 */

if(!function_exists('dd')) {
    function dd()
    {
        $args = func_get_args();
        echo '<pre>';
        if(count($args) > 1){
            foreach($args as $item){
                print_r($item);
            }
        }else{
            print_r(reset($args));
        }
        echo '</pre>';
        die('<br><font style="background: red;border:1px solid black">--STOP--</font>');
        exit();
    }
}
if(!function_exists('view')) {
    function view($path, $args=array())
    {
        foreach($args as $name => $item){
            $$name = $item;
        }
        include($path);
    }
}

if(!function_exists('csrf_field')) {
    function csrf_field()
    {
        printf("<input type='hidden' name='_token' value='%s'>", $_SESSION['token']);
    }
}

if(!function_exists('request_field')) {
    function request_field($post, $only=array())
    {
        $result = array();
        foreach($post as $name => $item){
            if(in_array($name, $only)){
                $result[$name] = $item;
            }
        }

        return $result;
    }
}

if(!function_exists('logg')) {
    function logg()
    {
        global $logger;

        ?>
        <div class="logger">
            <ul>
                <?php foreach($logger as $text):?>
                    <li><?=$text?></li>
                <?php endforeach?>

            </ul>
        </div>
        <?
    }
}