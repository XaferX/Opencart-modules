<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-emailform" data-toggle="tooltip" name="save"
                        title="<?php echo $button_save; ?>"
                        class="btn btn-primary">Сохранить
                </button>
                <button type="submit" form="form-emailform" data-toggle="tooltip" name="is_start"
                        title="<?php echo $button_save; ?>"
                        class="btn btn-success">Сохранить и применить
                </button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
                   class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>


    <div class="container-fluid">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i>Массовое управление скидками</h3>
            </div>


            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-emailform"
                      class="form-horizontal">


                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status">Название акции</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $promotion_name; ?>"
                                   name="promotion_name">
                            <?php if($error_promotion_name){ ?>
                            <div class="text-danger"><?php echo $error_promotion_name; ?></div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="form-group  input-group date">
                        <label class="col-sm-2 control-label" for="input-status">Дата начала</label>
                        <div class="col-sm-10">

                            <input type="text" name="date_start" value="<?php echo $date_from; ?>"
                                   placeholder="" data-date-format="YYYY-MM-DD" class="form-control"/>
                            <?php if($error_date_start){ ?>
                            <div class="text-danger"><?php echo $error_date_start; ?></div>
                            <?php } ?>
                        </div>

                          <span class="input-group-btn">
                          <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                          </span>

                    </div>

                    <div class="form-group  input-group date">
                        <label class="col-sm-2 control-label" for="input-status">Дата окончания</label>
                        <div class="col-sm-10">
                            <input type="text" name="date_end" value="<?php echo $date_to; ?>"
                                   placeholder="" data-date-format="YYYY-MM-DD" class="form-control"/>
                            <?php if($error_date_end){ ?>
                            <div class="text-danger"><?php echo $error_date_end; ?></div>
                            <?php } ?>
                        </div>
                          <span class="input-group-btn">
                          <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                          </span>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status">Тип Скидки</label>
                        <div class="col-sm-10">
                            <select name="special_type" class="form-control">
                                <option
                                <?php if($special_type ==1) echo 'selected="selected"'; ?> value="1">Процент</option>
                                <option
                                <?php if($special_type ==0) echo 'selected="selected"'; ?>
                                value="0">Фиксированная</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status">Акция/Скидка</label>
                        <div class="col-sm-10">
                            <select name="special_discount" class="form-control">
                                <option
                                <?php if($special_type ==1) echo 'selected="selected"'; ?> value="1">Акция</option>
                                <option
                                <?php if($special_type ==0) echo 'selected="selected"'; ?> value="0">Скидка</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status">Скидка</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $special; ?>" name="special">

                            <?php if($error_special){ ?>
                            <div class="text-danger"><?php echo $error_special; ?></div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status">Приоритет</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo $priority; ?>" name="priority">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status">Удалять другие скидочные цены</label>
                        <div class="col-sm-10">
                            <input type="checkbox" <?php echo  ($is_delete) ? 'checked="checked"' :'';  ?>
                            class="form-control" value="" name="is_delete">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-category"><span
                                    data-toggle="tooltip">Производители</span></label>
                        <div class="col-sm-10">
                            <input type="text" name="manufacturer" value=""
                                   id="input-manufacturer" class="form-control"/>
                            <div id="manufacturer" class="well well-sm" style="height: 150px; overflow: auto;">

                                <?php foreach ($manufacture_promo as $manufacture) { ?>
                                <div id="manufacturer<?php echo $manufacture['manufacturer_id']; ?>"><i
                                            class="fa fa-minus-circle"></i> <?php echo $manufacture['name']; ?>
                                    <input type="hidden" name="manufacturer_id[]"
                                           value="<?php echo $manufacture['manufacturer_id']; ?>"/>
                                </div>
                                <?php } ?>

                            </div>
                            <?php if($product_error){ ?>
                            <div class="text-danger"><?php echo $product_error; ?></div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-category"><span
                                    data-toggle="tooltip">Категории</span></label>
                        <div class="col-sm-10">



                            <input type="text" name="category" value="" placeholder="Категории" id="input-category"
                                   class="form-control"/>
                            <div id="category" class="well well-sm" style="height: 150px; overflow: auto;">
                                <?php foreach ($category_promo as $category) { ?>
                                <div id="product-category<?php echo $category['category_id']; ?>"><i
                                            class="fa fa-minus-circle"></i> <?php echo $category['name']; ?>
                                    <input type="hidden" name="category_id[]"
                                           value="<?php echo $category['category_id']; ?>"/>
                                </div>
                                <?php } ?>

                            </div>
                            <?php if($product_error){ ?>
                            <div class="text-danger"><?php echo $product_error; ?></div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="product_id">
                            <span data-toggle="tooltip" title="">Конкретные товары</span></label>
                        <div class="col-sm-10">

                            <input type="text" name="products" value="" id="products" class="form-control"/>
                            <div id="product_id" class="well well-sm" style="height: 150px; overflow: auto;">
                                <?php foreach ($custom_products as $product) { ?>
                                <div id="product_id<?php echo $product['product_id']; ?>"><i
                                            class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
                                    <input type="hidden" name="product_id[]"
                                           value="<?php echo $product['product_id']; ?>"/>

                                </div>
                                <?php } ?>
                            </div>
                            <?php if($product_error){ ?>
                            <div class="text-danger"><?php echo $product_error; ?></div>
                            <?php } ?>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
    <link href="view/javascript/summernote/summernote.css" rel="stylesheet"/>
    <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>

    <script type="text/javascript">


        // Related
        $('input[name=\'products\']').autocomplete({
            'source': function (request, response) {
                $.ajax({
                    url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                    dataType: 'json',
                    success: function (json) {
                        response($.map(json, function (item) {
                            return {
                                label: item['name'],
                                value: item['product_id']
                            }
                        }));
                    }
                });
            },
            'select': function (item) {
                $('input[name=\'products\']').val('');
                console.log(item);
                $('#product_id' + item['value']).remove();

                $('#product_id').append('<div id="product_id' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_id[]" value="' + item['value'] + '" /></div>');
            }
        });


        $('#product_id').delegate('.fa-minus-circle', 'click', function () {
            $(this).parent().remove();
        });


        $('.date').datetimepicker({
            pickTime: false
        });


        $('#category').delegate('.fa-minus-circle', 'click', function () {
            $(this).parent().remove();
        });
        $('#manufacturer').delegate('.fa-minus-circle', 'click', function () {
            $(this).parent().remove();
        });

        $('input[name=\'manufacturer\']').autocomplete({
            'source': function (request, response) {
                $.ajax({
                    url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                    dataType: 'json',
                    success: function (json) {
                        json.unshift({
                            manufacturer_id: 0,
                            name: '--нет--'
                        });

                        response($.map(json, function (item) {
                            return {
                                label: item['name'],
                                value: item['manufacturer_id']
                            }
                        }));
                    }
                });
            },
            'select': function (item) {


                $('input[name=\'manufacturer\']').val('');

                $('#manufacturer' + item['value']).remove();

                $('#manufacturer').append('<div id="manufacturer' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="manufacturer_id[]" value="' + item['value'] + '" /></div>');

            }
        });


        // Category
        $('input[name=\'category\']').autocomplete({
            'source': function (request, response) {
                $.ajax({
                    url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                    dataType: 'json',
                    success: function (json) {
                        response($.map(json, function (item) {
                            return {
                                label: item['name'],
                                value: item['category_id']
                            }
                        }));
                    }
                });
            },
            'select': function (item) {
                $('input[name=\'category\']').val('');

                $('#category' + item['value']).remove();

                $('#category').append('<div id="category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="category_id[]" value="' + item['value'] + '" /></div>');
            }
        });


    </script>


    <script type="text/javascript"><!--
        $('#language a:first').tab('show');
        //--></script>
</div>


<?php echo $footer; ?>
