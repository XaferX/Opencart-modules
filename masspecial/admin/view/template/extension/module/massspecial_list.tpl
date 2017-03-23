<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">

    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <a class="btn btn-primary" href="<?php echo $action_create; ?>">Добавить Акцию/Скидку</a>
                <button class="btn btn-danger " onclick="deletePromotion()" href="">Удалить все акции</button>

            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>


    <div class="panel panel-default">
        <div class="panel-body">
            <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-product">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>


                            <td class="text-left">
                                <a href="<?php echo $sort_name; ?>">ID акции</a>
                            </td>
                            <td class="text-left">
                                <a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>">Название
                                    акции</a>
                            </td>
                            <td class="text-right">
                                <a href="<?php echo $sort_price; ?>"
                                   class="<?php echo strtolower($order); ?>">Скидка</a>
                            </td>
                            <td class="text-right">
                                <a href="<?php echo $sort_quantity; ?>" class="">Дата создание</a>
                            </td>
                            <td class="text-left">
                                <a href="<?php echo $sort_status; ?>" class="">Дата запуска акции</a>
                            </td>
                            <td class="text-right">Статус Акции</td>
                            <td class="text-right">Действие</td>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if (isset($promotions) && !empty($promotions)) { ?>
                        <?php foreach ($promotions as $promotion) { ?>
                        <tr>

                            <td class="text-left"><?php echo $promotion['promotion_id']; ?></td>
                            <td class="text-left"><?php echo $promotion['data']['promotion_name']; ?></td>
                            <td class="text-left"><?php echo $promotion['data']['special']; ?> <?php echo ($promotion['data']['special_type']==1) ? '%' : 'Фиксир'  ?> </td>
                            <td class="text-left"><?php echo $promotion['date_create']; ?></td>
                            <td class="text-left"><?php echo $promotion['date_start']; ?></td>
                            <td class="text-right"><?php echo !empty($promotion['date_start']) ? 'запущена' : 'незапущена'; ?></td>

                            <td class="text-right"><a href="<?php echo $promotion['action']; ?>" data-toggle="tooltip"
                                                      title="Редактировать акцию" class="btn btn-primary"><i
                                            class="fa fa-pencil"></i></a></td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
    
    
    
    <script>
        
        
        function deletePromotion() {

         $password =   prompt("Введите секретный пароль который знает только TechLead");

            location.href ='<?php echo $action_delete; ?>&password=' + $password;

        }
        
    </script>
</div>