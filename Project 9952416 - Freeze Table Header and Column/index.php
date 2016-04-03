<?php

echo '<link rel="stylesheet" type="text/css" href="styles.css">';
echo '<script type="text/javascript" src="jquery.min.js"></script>';
?>



<?

$list=array();

$year = 2016;
$monthDaysCount=array(0,0,0,0,0,0,0,0,0,0,0,0,0);
$monthDaysName=array("","","","","","","","","","","","","");

echo "Year = " . $year . "<br><br>";

// count the max number of cells required in the rows
$MaxCells = 0;
for($m=1;$m<=12;$m++){  // loop each month
	$ThisStartDate = strtotime($year . "-" . substr("00".$m, -2) . "-" . "01");
	$ThisMonthDaysCount = intval(date("t",$ThisStartDate));
	$monthDaysCount[$m] = $ThisMonthDaysCount;
	$monthDaysName[$m] = date("F",$ThisStartDate);
	$MaxCells = $MaxCells + $ThisMonthDaysCount;
}
$MaxCells++; // add 1 column for the first column of row numbers


echo "MaxCells = ".$MaxCells."<br>";
// create the table
?>
<html><head>


<style type="text/css">
	#boundary {
		position: relative;
		overflow: scroll;
		height: 400px;
	}
</style>

	

	
</head>

<body>

<div id='aa'>xx</div><br><br>
<div id='bb'>xx</div><br><br>
<div id='scrollCounter'>xx</div><br><br>

<div id="boundary">
<table id="table1" border="1" class="tbl">

<?
	//add the first column heading
	echo "<tr class='dayname'><td class='month'>Row No.</td>";

	// add the first row headings - month names
	for($m=1;$m<=12;$m++){
		echo "<td class='month' colspan='".$monthDaysCount[$m]."'>".$monthDaysName[$m]."</td>";
	}	
	echo "</tr>";
	// month names have been added

	// add the second row headings - dates
	echo "<tr class='dayname'><td></td>";
	for($m=1;$m<=12;$m++){
		for($d=1;$d<=$monthDaysCount[$m];$d++){
			echo "<td class='daynum'>".$d."</td>";
		}	
	}
	echo "</tr>";
	// second row headings been added

	//now add 100 rows of random data for testing
	$TestDataPos = 0;
	for($r=1;$r<=100;$r++){
		echo "<tr id='r".$r."' class='dayname'><td><div>";
		echo $r;   // add the row ID number
		echo "</div></td>";
		//determine the cell number of the test data
		$TestDataPos = $TestDataPos + 3;
		if($r % 10 == 0){ $TestDataPos = $TestDataPos - 5;}
		//add a cell for each date, and populate with test data if the cell number / count = $TestDataPos
		for($c=1;$c<$MaxCells;$c++){
			echo "<td id='r".$r."c".$c."' class='daynum'><div>";
			if($c == $TestDataPos){
				echo "Y";
			}else{
				echo "-";
			}
			echo "</div></td>";
		}
		echo "</tr>";
	}

?>

</table>
</div>

<script type="text/javascript">

$('#fixed_hdr1').fxdHdrCol({
	fixedCols: 3,
	width:     "100%",
	height:    400,
	colModal: [
	   { width: 50, align: 'center' },
	   { width: 110, align: 'center' },
	   { width: 170, align: 'left' },
	   { width: 250, align: 'left' },
	   { width: 100, align: 'left' },
	   { width: 70, align: 'left' },
	   { width: 100, align: 'left' },
	   { width: 100, align: 'center' },
	   { width: 90, align: 'left' },
	   { width: 400, align: 'left' }
	]					
});

var scrollCounter = 0;
var GoLeft = 0;

	function isElementInViewport(par, el) {
		var elRect = el.getBoundingClientRect(),
			parRect = par.getBoundingClientRect();
		return (
			elRect.top >= parRect.top &&
			elRect.bottom <= parRect.bottom
		);
	}

	function check() {
	
		var LeftMost = 999;
		var container = document.getElementById("boundary"),
			tr = container.getElementsByTagName("tr"),
			visible = [],
			i, j, cur;
		for (i = 0, j = tr.length; i < j; i++) {
			cur = tr[i];
			if (isElementInViewport(container, cur)) {
				visible.push(cur.id);
				//get the first instance of a 'Y' as follows :		
				for (x = 1, z = 360; x < z; x++) {
					if(document.getElementById(cur.id + "c" + x).innerHTML == "<div>Y</div>"){
						if(x <= LeftMost) {
							LeftMost = x;
							x = z;
						}
					}
				}
			}
		}
		document.getElementById("aa").innerHTML = ("Visible rows:", visible.join(", "));
		document.getElementById("bb").innerHTML = LeftMost;
		GoLeft = 23 * LeftMost;
		document.getElementById("scrollCounter").innerHTML = GoLeft;
	}

	function addEvent(element, eventName, callback) {
		if (element.addEventListener) {
			element.addEventListener(eventName, callback, false);
		} else if (element.attachEvent) {
			element.attachEvent("on" + eventName, callback);
		}
	}



	addEvent(window, "load", function () {
		addEvent(document.getElementById("boundary"), "scroll", check);
	});


	$(document.getElementById("boundary")).scroll(function() {
		clearTimeout($.data(this, 'scrollTimer'));
		$.data(this, 'scrollTimer', setTimeout(function() {
			$(document.getElementById("boundary")).scrollLeft(GoLeft);
		}, 50));
	});


</script>
	
</body>
</html>
