<?php
    // ** Error code:
    // 0 = Success
    // 1 = Item exists

    session_start();
    $action = $_POST['action'];
    
    if(stripos($action, "_")) {
        $action = explode("_", $action);
        $action = $action[0];
    }
    
    file_put_contents("debug.txt", $action, FILE_APPEND);    
    $itemId = isset($_POST['id']) ? $_POST['id'] : '';
    $returnvalue = array();
    
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = '';
    }
    
    switch($action){
        case 'add' :
            $product_meta = isset($_POST['product_desc']) ? $_POST['product_desc'] : '';
            
            if(isset($_SESSION['cart'][$itemId])) {
                $returnvalue['text'] = "Item already exist in cart";
                $returnvalue['error_code'] =  1;
            } else {
                $update_count = isset($_POST['update_count']) ? $_POST['update_count'] : 1;
                
                $_SESSION['cart'][$itemId] = array($itemId);
                $_SESSION['cart'][$itemId]['num'] = $update_count;
                $_SESSION['cart'][$itemId]['image'] = $product_meta[0];
                $_SESSION['cart'][$itemId]['cost'] = $product_meta[1];
                
                $returnvalue['text'] = "Item added to cart";
                $returnvalue['error_code'] =  0;
                $returnvalue['HTML'] = '<div> <img src="'.$_SESSION['cart'][$itemId]['image'].'" /> ['.$_SESSION['cart'][$itemId]['num'].']&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="cart(\'update_plus\', '.$itemId.');">+</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="cart(\'update_sub\', '.$itemId.');">-</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="cart(\'deleteItem\', '.$itemId.');">Delete</a></div>';
            }
            
            break;
        
        case 'update' :
            $update_count = isset($_POST['update_count']) ? $_POST['update_count'] : NULL; 
            $which = isset($_POST['which']) ? $_POST['which'] : NULL; 
            
            if(isset($_SESSION['cart'][$itemId]) && $update_count) {
                $_SESSION['cart'][$itemId]['num'] = $update_count;
                $returnvalue['error_code'] = 0;
            } else if(isset($_SESSION['cart'][$itemId]) && !$update_count){
                if($which == 'add')
                    $_SESSION['cart'][$itemId]['num'] += 1;
                else if($which == 'sub'){
                    $_SESSION['cart'][$itemId]['num'] -= 1;
                }
                
                if($_SESSION['cart'][$itemId]['num'] == 0) {
                    unset($_SESSION['cart'][$itemId]);
                }
                $returnvalue['error_code'] = 0;
            } else {
                $returnvalue['error_code'] = 1;
                $returnvalue['text'] = 'Item does\'t exists';
            }

            break;
        
        case 'delete' :
            if(isset($_SESSION['cart'][$itemId])){
                unset($_SESSION['cart'][$itemId]);
                
                $returnvalue['text'] = 'Item was deleted successfully.';
                $returnvalue['error_code'] = 0;
            } else {
                $returnvalue['text'] = 'Item doesn\'t exist in cart.';
                $returnvalue['error_code'] = 1;
            }            
            
            break;
        
        case 'view' :
            $mode = $_POST['mode'];
            
            switch ($mode) {
                case 'small' :
                    foreach($_SESSION['cart'] as $key => $value ):
                        $returnvalue['HTML'][$key] = '<div style="width: 50px; height: 50px; float: left; margin-right: 20px;"> $'.(intval(substr($_SESSION['cart'][$key]['cost'], 1)) * intval($_SESSION['cart'][$key]['num'])).'<img style="max-width: 100%;" src="'.$_SESSION['cart'][$key]['image'].'" /> <br/>['.$_SESSION['cart'][$key]['num'].']<br/><a href="javascript:void(0)" onclick="cart(\'update_plus\', '.$key.');">+</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="cart(\'update_sub\', '.$key.');">-</a><br/><span></span>&nbsp;&nbsp;<br/><a href="javascript:void(0)" onclick="cart(\'deleteItem\', '.$key.');">Delete</a></div>';
                    endforeach;
                    break;
                case 'normal':
                    
                    break;
            }
            
            break;
    }
    
    echo json_encode($returnvalue);
?>
