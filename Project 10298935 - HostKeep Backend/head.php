<?php
echo '
<script src="js/external/jquery.min.js"></script>
<script src="js/external/bootstrap.min.js"></script>
<script src="js/external/toastr.min.js"></script>
<script src="js/external/moment.min.js"></script>
<script src="js/external/hashchange.min.js"></script>
<script src="js/global.js?' . filemtime('js/global.js') . '"></script>

<link href="css/external/bootstrap.min.css" rel="stylesheet"/>
<link href="css/external/toastr.min.css" rel="stylesheet"/>
<link href="css/global.css?' . filemtime('css/global.css') . '" rel="stylesheet"/>
'
?>
