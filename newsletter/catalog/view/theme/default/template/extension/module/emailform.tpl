<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>

<div class="text-buy-holder">
    <div class="title-buy-holder">
        <h1 class="big-title buy-title">  <?php echo $heading_title;?><span class="open-buy-title"><i
                        class="material-icons">&#xE313;</i></span></h1>
        <div class="hidden_text container"
             style="display: none;"> <?php  echo mb_substr(trim($text),0,300,'UTF-8'); ?></div>
    </div>
    <div class="hid-text-buy">
        <div class="container">
            <div class="grad-white"></div>

            <div class="row">
                <div class="col-xs-12">

                    <?php echo $text; ?>

                </div>
            </div>
        </div>
    </div>
    <?php if(!$hide_module): ?>

    <div class="container">

        <div class="row">
            <div class="col-xs-12">

                <form id="subscribe_form">
                    <fieldset>
                        <input type="email" name="email" placeholder="E-mail"
                               class="email-transparent">
                        <button type="submit" class="btn-green btn btn-primary"><?php echo $text_subscribe; ?></button>
                    </fieldset>
                </form>
                <p class="not-spam"><?php echo $text_not_spam; ?></p>
            </div>
        </div>
    </div>

    <?php endif; ?>
</div>


<script>
    $('button[type=submit].btn-green').on('click', function (e) {

        var $strEmail = $('#subscribe_form input[name=email]').val();
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'index.php?route=extension/module/emailform/email',
            dataType: 'json',
            data: {
                email: $strEmail
            },
            success: function (json) {
                if (json.success) {
                    alert(json.success, 'success');
                    $('.text-buy-holder ').children('.container').remove();

                } else if (json.error) {
                    alert(json.error, 'error');

                }


            }
        });


    });


</script>
