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
                            <div id='quizTitle' class="col-xs-12 quizInfoPanels" style="margin-left:20px;">
                            </div></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div  class="col-xs-12 quizInfoPanels" >
                                <div class="panel panel1  panel-success" style="margin-bottom: 0px !important;">
                                    <div class="panel-heading clickable"><h2 class="panel-title"> Quiz Info</h2><span class="pull-right "><i class="glyphicon glyphicon-minus"></i></span></div>
                                    <div class="panel-body line " id='quizInfo'></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="col-xs-12 quizInfoPanels" >
                                <div class="panel panel1  panel-success" style="margin-bottom: 0px !important;">
                                    <div class="panel-heading clickable"><h2 class="panel-title"> Quiz Prizes</h2><span class="pull-right "><i class="glyphicon glyphicon-minus"></i></span></div>
                                    <div class="panel-body line " id='quizPrizes'></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id='' class="col-xs-12 quizInfoPanels" >
                                <div class="panel panel1  panel-success" style="margin-bottom: 0px !important;">
                                    <div class="panel-heading clickable"><h2 class="panel-title"> Quiz Rules</h2><span class="pull-right "><i class="glyphicon glyphicon-minus"></i></span></div>
                                    <div class="panel-body line " id='quizRules'></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id='' class="col-xs-12 quizInfoPanels" >
                                <div class="panel panel1  panel-success" style="margin-bottom: 0px !important;">
                                    <div class="panel-heading clickable"><h2 class="panel-title"> Quiz Leaders</h2><span class="pull-right "><i class="glyphicon glyphicon-minus"></i></span></div>
                                    <div class="panel-body line " id='quizUsers'></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id='quizQnsDiv'  class="col-xs-12 quizInfoPanels" >
                                <div class="panel panel1  panel-success" style="margin-bottom: 0px !important;">
                                    <div class="panel-heading clickable"><h2 class="panel-title"> Quiz Questions</h2><span class="pull-right "><i class="glyphicon glyphicon-minus"></i></span></div>
                                    <div class="panel-body line " id='quizQuestions'></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

</div>

<?php include('footer.php'); ?>


<!--<script type="text/javascript" src="assets/js/jquery.cslider.js"></script>
<script>
    $("#rfpform").validate();
</script>-->
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
