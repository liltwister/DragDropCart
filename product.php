<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Shopping Cart | Dray and Drop</title>
        <link rel="stylesheet" href="style.css"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="script.js" type="text/javascript"></script>
    </head>
    <body>
        <?php
        ?>
        <a href="index.php">Home</a>
        <div class="drag_container" data-cost ="10.00" data-itemId = "123" data-image = "http://livelyworks.net/cc-demo/jQueryPHPStoreDemo/uploads/thumb/camera_on_the_floor-other.jpg?1378372841" style="float: left; width: 100px; height: 100px; background-color: lightgray; margin-right: 10px; margin-bottom: 10px;">
            <div>
                <img src="http://livelyworks.net/cc-demo/jQueryPHPStoreDemo/uploads/thumb/camera_on_the_floor-other.jpg?1378372841" style="max-width: 100%;"/>
                <span class="price">$10.00</span>
                <span>This is a test description.</span>
            </div>
        </div>
        <div class="drag_container" data-cost ="10.00" data-itemId = "122" data-image = "http://livelyworks.net/cc-demo/jQueryPHPStoreDemo/uploads/thumb/camera_on_the_floor-other.jpg?1378372841" style="float: left; width: 100px; height: 100px; background-color: lightgray; margin-right: 10px; margin-bottom: 10px;">
            <div>
                <img src="http://livelyworks.net/cc-demo/jQueryPHPStoreDemo/uploads/thumb/red_tomatoes-other.jpg?1378379851" style="max-width: 100%;"/>
                <span class="price">$5.00</span>
                <span>This is a test description.</span>
            </div>
        </div>
        <div id="drop_container" style="width: 900px; height: 200px; margin: 10px auto; border: 1px solid silver; position: fixed; bottom: 0; left: 0;"></div>
    
        <script>
            $(function(){
                $.shoppingCart({}, 'cart');
            });
            
            function cart(action, id) {
               $.shoppingCart({}, action, id);
            }
        </script>
    </body>
</html>
