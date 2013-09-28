(function($){
   $.extend({
       shoppingCart : function(options, method, args) {
           return $.shoppingCart.methods.init(options, method, args);
       }
   });
   
   var defaults = {
       drop_container : "drop_container",
       drag_container : "drag_container"
   }, settings;
   
   $.shoppingCart.methods = {
        init : function(options, method, args){
            settings = $.extend({}, defaults, options);
            
            $("."+settings.drag_container).draggable({
                helper: "clone"
            });
            
            $("#"+settings.drop_container).droppable({
                accept : "."+settings.drag_container,
                activeClass: "ui-state-highlight",
                drop : function(event, ui){
                    $.shoppingCart.methods.add(ui.draggable);
                }
            });
            
            if((typeof $.shoppingCart.methods[method]) != 'undefined'){
                if(args) {
                    $.shoppingCart.methods[method](args);
                } else {
                    $.shoppingCart.methods[method]();
                }
            }
        },

        cart : function(){
            $("#"+settings.drop_container).html("");
            $.post("cart.php", {action : 'view', mode : 'small'}, function(data){
                if(data.length != 0) {
                    $("#"+settings.drop_container).html("");
                    $.each(data, function(){
                        $.each(this, function(name, value){
                           $("#"+settings.drop_container).append(value);
                        });
                    });
                } else {
                    $("#"+settings.drop_container).html("<h1>Your cart is empty.</h1>");
                }
            }, 'json');
        },

        add : function(item){
            var itemId = item.data('itemid'),
                itemImage = item.find('img').attr('src'),
                itemPrice = item.find('.price').text();
                        
            var items_meta = [];
            items_meta[0] = itemImage;
            items_meta[1] = itemPrice;
            
            $.post("cart.php", {action : 'add', id : itemId, 'product_desc[]' : items_meta}, function(data){
                switch(data.error_code) {
                    case 0:
                        $.shoppingCart.methods.cart();
                        break;
                    case 1:
                        alert(data.text);
                        break;
                }
            }, 'json');
        },

        update_plus : function(itemId){
            $.post("cart.php", {action : 'update', id : itemId, 'which' : 'add'}, function(data){
                switch(data.error_code) {
                    case 0:
                        $.shoppingCart.methods.cart();
                        break;
                    case 1:
                        alert(data.text);
                        break;
                }
                
            }, 'json');
        },
                
        update_sub : function(itemId){
            $.post("cart.php", {action : 'update', id : itemId, 'which' : 'sub'}, function(data){
                switch(data.error_code) {
                    case 0:
                        $.shoppingCart.methods.cart();
                        break;
                    case 1:
                        alert(data.text);
                        break;
                }
                
            }, 'json');
        },

        deleteItem :  function(itemId){
            $.post("cart.php", {action : 'delete', id : itemId}, function(data){
                switch(data.error_code) {
                    case 0:
                        $.shoppingCart.methods.cart();
                        break;
                    case 1:
                        break;
                }
                
                alert(data.text);
            }, 'json');
        },

        save : function(){

        },

        session : function(){

        }
   };
})(jQuery);

