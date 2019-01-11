$(function () {
    html = $('html');

    html.on('click', 'button[data-target="#modal"]', function (event) {
        event.preventDefault();
        type = $(this).attr('data-type');
        id = null;

        modal = html.find('div#modal');
        switch (type){
            case 'add':
                modal.find('h5#modalLabel').text("Добавить товар");
                html.find('div.modal-body').find('input[name="name"], input[name="description"], input[name="price"]').val('');
                modal.find('.modal-footer button.btn-primary').attr('data-change','add').text('Добавить');
                break;
            case 'edit':
                modal.find('h5#modalLabel').text("Редактировать товар");
                id = $(this).attr('data-id');
                modal.find('.modal-footer button.btn-primary').attr('data-change','edit').text('Сохранить');
                edit(id);
                break;
        }
    });

    html.on('click', 'button[data-change="edit"]', function(e) {
        e.preventDefault();

        body = html.find('div.modal-body');
        name = body.find('input[name="name"]').val();
        description = body.find('input[name="description"]').val();
        price = body.find('input[name="price"]').val();
        status = body.find('select[name="status"] option:selected').val();
        token = body.find('input[name="_token"]').val();
        id = body.find('input[name="id"]').val();
        error = false;

        body.find('input').each(function(){
            if(!$(this).val()){
                $(this).css('border', '1px solid red');
                error = true;
            }
        });

        posted('/product/update', {id:id, name:name, description:description,price:price, token:token, status:status});
    });
    html.on('click', 'button[data-change="add"]', function(e){
        e.preventDefault();

        body = html.find('div.modal-body');
        name = body.find('input[name="name"]').val();
        description = body.find('input[name="description"]').val();
        price = body.find('input[name="price"]').val();
        status = body.find('select[name="status"] option:selected').val();
        token = body.find('input[name="_token"]').val();
        error = false;

        body.find('input').each(function(){
           if(!$(this).val()){
               $(this).css('border', '1px solid red');
               error = true;
           }
        });

        if(!error){
            posted('/product/add', {name:name, description:description, price:price, status:status, token:token});
            html.find('table.table tbody').append('<tr class="insert">\n' +
                '                <th scope="row" data-name="id"><div class="loader"><img src="/resource/assets/image/loader.gif" alt=""></div></th>\n' +
                '                <td data-name="name">'+name+'</td>\n' +
                '                <td data-name="description">'+description+'</td>\n' +
                '                <td data-name="status">'+status+'</td>\n' +
                '                <td data-name="price">'+price+'</td>\n' +
                '                <td>\n' +
                '                   <button type="button" class="btn btn-primary" data-toggle="modal" data-type="edit" data-id="insert" data-target="#modal">\n' +
                '                       <i class="fas fa-edit"></i>\n' +
                '                   </button>\n' +
                '                   <button type="button" class="btn btn-danger" data-toggle="modal" data-type="del" data-id="insert" data-target="#modal">\n' +
                '                       <i class="fas fa-trash-alt"></i>\n' +
                '                   </button>\n' +
                '                </td>\n' +
                '            </tr>');
        }else{
            console.error('Ошибка заполнение данных');
        }

        console.log(name, description, price, status, token);
    });
    html.on('click', 'button.btn-danger', function(){
        id = $(this).attr("data-id");
        token = html.find('input[name="_token"]').val();
        popup = html.find('div.popup');

        if($(this).attr('data-type') === "del"){
            status = 0;
            popup.find('.popup .modal-body').css('background-color', '#dc3545').find('h2').text('Товар удален!');
        }else{
            status = 1;
            popup.find('.popup .modal-body').css('background-color', '#0f8845').find('h2').text('Товар восстановлен!');
        }
        $(this).parent().html('<div class="loader"><img src="/resource/assets/image/loader.gif" alt=""></div>');
        posted("product/status", {id:id, status:status, token:token});
    });

    function edit(id){
        row = html.find('tr[data-id="'+id+'"]');

        name = row.find('td[data-name="name"]').text();
        description = row.find('td[data-name="description"]').text();
        price = row.find('td[data-name="price"]').text();
        status = row.find('td[data-name="status"]').text();

        body = html.find('div.modal-body');
        body.find('input[name="name"]').val(name);
        body.find('input[name="description"]').val(description);
        body.find('input[name="price"]').val(price);
        body.find('input[name="status"]').val(status);
        body.append("<input type='hidden' name='id' value='"+id+"'>");

        console.log(name, description, price, status);
    }
    function posted(url, collection){
        $.post( url, collection, function( data ) {
            if(data) {
                html.find('table tr.insert').find('th[data-name="id"]').text(data);
                html.find('table tr.insert').find('button[data-id="insert"]').attr('data-id', data);
            }
            data_find = $(data).find('table');
            html_find = html.find('table');
            html_find.html(data_find.html());
        });
    }

    html.on('change', 'select#orderby', function(e){
        e.preventDefault();
        value = $(this).val();
        history.pushState('', '', '?orderby='+value);

        $.get('product/orderby', {orderby:value}, function(data){
            data_find = $(data).find('table');
            html_find = html.find('table');
            html_find.html(data_find.html());
        });

    });
});