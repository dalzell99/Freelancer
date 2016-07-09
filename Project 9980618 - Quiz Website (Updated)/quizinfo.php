<?php include('header.php'); ?>
<?php
echo '<link href="css/external/flipclock.css" rel="stylesheet">';
echo '<script src="js/external/flipclock.js" type="application/javascript"></script>';
echo '<link rel="stylesheet" type="text/css" href="css/quizinfo.css?' . filemtime('css/quizinfo.css') . '" />';
echo '<script type="text/javascript" src="js/quizinfo.js?' . filemtime('js/quizinfo.js') . '"></script>';
?>
<div class="container-fluid">

    <!-- <div class="container" id='showIfLoggedIn'>
        <div id="no-more-tables" class="margin-top">
            <div class="col-md-2"></div>
            <table class="col-md-8 col-sm-8 col-lg-8 col-xs-12 table-bordered table-striped table-condensed cf margin-top">
                <thead class="cf table-head" >
                    <tr>
                        <th class="thead1" >
                            <div id='quizTitle' class="col-xs-12 quizInfoPanels">
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
    </div> -->
    <div class='col-xs-12 col-md-10 col-md-push-1'>
        <div class='row'>
            <div class='col-md-8' id='quizInfoTitle'>

            </div>
            <div class='col-md-4' id='quizInfoCountdown'>

            </div>
        </div>
        <div class='row'>
            <div class='col-sm-6 col-lg-4' id='quizInfoInfo'>

            </div>
            <div class='col-sm-6 col-lg-4' id='quizInfoLeader'>

            </div>
            <div class='col-sm-6 col-lg-4' id='quizInfoRegistration'>

            </div>
            <div class='col-sm-6 col-lg-4' id='quizInfoPrizes'>

            </div>
            <div class='col-sm-6 col-lg-4' id='quizInfoRules'>

            </div>
            <div class='col-sm-6 col-lg-4' id='quizInfoQuestions'>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="startTimeChangeModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default timeChangeButtons" data-dismiss="modal" onclick='saveTimeChange()'>Save</button>
        <button type="submit" class="btn btn-default timeChangeButtons" data-dismiss="modal">Cancel</button>
      </div>
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
