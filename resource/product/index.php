<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/resource/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/resource/assets/css/product.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

    <title>Товары</title>
</head>
<body>

<div class="container">
    <div class="col-md-12" style="padding: 10px">
        <dir class="row">
            <div class="col-md-4">
                <p>Добавить товар</p>
                <button id="add" type="button" class="btn btn-success" data-toggle="modal" data-type="add"
                        data-target="#modal">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="col-md-4 offset-4">
                <div class="form-group">
                    <label for="orderby">Сортировка:</label>
                    <select name="price" id="orderby" class="form-control">
                        <option value="price=desc">Цена по убыванию</option>
                        <option value="price=asc">Цена по возрастанию</option>
                        <option value="name=desc">Имя по убыванию</option>
                        <option value="name=asc">Имя по возрастанию</option>
                    </select>
                </div>
            </div>
        </dir>
    </div>
    <table class="table table-hover table-dark">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Имя</th>
            <th scope="col">Описание</th>
            <th scope="col">Цена</th>
            <th scope="col">Статус</th>
            <th scope="col">
                <div class="loader">
                    <img src="/resource/assets/image/loader.gif" alt="">
                </div>
            </th>
        </tr>
        </thead>
        <?php if ($args): ?>
            <tbody>
            <?php foreach ($args as $item): ?>
                <?php if(!$item->status):?>

                <tr>
                    <td></td>
                    <td></td>
                    <td>Удалено</td>
                    <td></td>
                    <td></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" data-type="reset"
                                data-id="<?= $item->id ?>"
                                data-toggle="modal" data-target=".bs-example-modal-lg">
                            Востановить
                        </button>
                    </td>
                </tr>
                <?php else: ?>
                    <tr data-id="<?= $item->id ?>">
                        <th scope="row"><?= $item->id ?></th>
                        <td data-name="name"><?= $item->name ?></td>
                        <td data-name="description"><?= $item->description ?></td>
                        <td data-name="price"><?= $item->price ?></td>
                        <td data-name="status"><?= $item->status() ?></td>
                        <td data-name="property">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-type="edit"
                                    data-id="<?= $item->id ?>" data-target="#modal">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger" data-type="del" data-id="<?= $item->id ?>"
                                    data-toggle="modal" data-target=".bs-example-modal-lg">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                <?php endif ?>

            <?php endforeach ?>
            </tbody>
        <?php else:?>
            <tbody>
                <tr><td>Товаров нет!</td></tr>
            </tbody>
        <?php endif ?>
    </table>
</div>

<footer>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Добавление товара</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" id="description" class="form-control" name="description">
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" id="price" class="form-control" name="price">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="0">Заморозить</option>
                            <option value="1" selected>Активный</option>
                        </select>
                    </div>
                    <?= csrf_field() ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" data-type="prim" class="btn btn-primary">Сохранить
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="popup modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="popup">
        <div class="modal-dialog modal-lg popup">
            <div class="modal-content">
                <div class="modal-body">
                    <H2>Заголовок</H2>
                </div>
            </div>
        </div>
    </div>
    <script src="/resource/assets/js/jquery-3.3.1.slim.min.js"></script>
    <script src="/resource/assets/js/bootstrap.js"></script>
    <script src="/resource/assets/js/product.js"></script>
</footer>
</body>

</html>

