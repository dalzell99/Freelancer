<?php include('header.php'); ?>
<?php
echo '<link href="css/external/flipclock.css" rel="stylesheet">';
echo '<script src="js/external/flipclock.js" type="application/javascript"></script>';
echo '<link rel="stylesheet" type="text/css" href="css/quizinfo.css?' . filemtime('css/quizinfo.css') . '" />';
echo '<script type="text/javascript" src="js/quizinfo.js?' . filemtime('js/quizinfo.js') . '"></script>';
?>
<div class="container-fluid"  style=" background: url(images/backgrond.png); min-height:600px;"> 

    <div class="container">
        <div id="no-more-tables" class="margin-top">
            <div class="col-md-2"></div>
            <table class="col-md-8 col-sm-8 col-lg-8 col-xs-12 table-bordered table-striped table-condensed cf margin-top">
                <thead class="cf table-head" >
                    <tr>
                        <th class="thead1" >
                        <div id='quizTitle' class="col-xs-12 quizInfoPanels" style="margin-left:20px;    margin: -9px 0px -4px -140px;">
                        </div></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div id='quizInfo' class="col-xs-12 quizInfoPanels" ></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id='quizPrizes' class="col-xs-12 quizInfoPanels" ></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id='quizRules' class="col-xs-12 quizInfoPanels" ></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id='quizUsers' class="col-xs-12 quizInfoPanels" ></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id='quizQuestions' class="col-xs-12 quizInfoPanels" ></div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Start Quizzes -->
<!--            <div class='row'>
                <div id='quizTitle' class="col-xs-12 quizInfoPanels" ></div>
                <div id='quizInfo' class="col-xs-12 quizInfoPanels" ></div>
                <div id='quizPrizes' class="col-xs-12 quizInfoPanels" ></div>
                <div id='quizRules' class="col-xs-12 quizInfoPanels" ></div>
                <div id='quizUsers' class="col-xs-12 quizInfoPanels" ></div>
                <div id='quizQuestions' class="col-xs-12 quizInfoPanels" ></div>
            </div>-->
            <!-- End Quizzes -->

        </div>
    </div>
</div>

</div>

<?php include('footer.php'); ?>


<script type="text/javascript" src="assets/js/jquery.cslider.js"></script>
<script>
    $("#rfpform").validate();
</script>
<script>
$(document).on('click', '.panel-heading span.clickable', function (e) {
    var $this = $(this);
    if (!$this.hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideUp();
        $this.addClass('panel-collapsed');
        $this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
    } else {
        $this.parents('.panel').find('.panel-body').slideDown();
        $this.removeClass('panel-collapsed');
        $this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).on('click', '.panel div.clickable', function (e) {
    var $this = $(this);
    if (!$this.hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideUp();
        $this.addClass('panel-collapsed');
        $this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
    } else {
        $this.parents('.panel').find('.panel-body').slideDown();
        $this.removeClass('panel-collapsed');
        $this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).ready(function () {
    $('.panel-heading span.clickable').click();
    $('.panel div.clickable').click();
});

</script>
