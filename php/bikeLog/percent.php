<?php

    require_once "../database_connections.php";
	global $conn;
	mysqli_select_db($conn, "bike") or die (mysqli_error($conn));
	
	
	/// gets the number
	if (isset($_GET["mode"])) {
		
		$sql = "select count(*) as cnt from steps where date(eventtime) = CURDATE();";
		$result = mysqli_query($conn, $sql);		
		$row = $result->fetch_array(MYSQLI_ASSOC);
		
		die($row["cnt"]);
	} 

	$sql = "select value as target from settings where name = 'targetSteps'";
	$result = mysqli_query($conn, $sql);		
	$row = $result->fetch_array(MYSQLI_ASSOC);

	
?>
<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
<script src="jquery.progress.js"></script>


<body>
	Target:<span id="target" ></span><hr>
	Done:<span id="done"></span><hr>
	Percent:<span id="percent"></span><hr>
	<svg id="container"></svg>
</body>


<script>
var target = <?php echo $row["target"]; ?>;
var done = 0;


function refresh() {
	
	$.ajax({
		url: "/bikeLog/percent.php",
		data: {
			mode: 1
		},
		success: function( result ) {
			done = result; 
			
			var prc = Math.floor(done / target * 100);
	
			$( "#target" ).html( "<strong>" + target + "</strong>" );
			$( "#done" ).html( "<strong>" + done + "</strong>" );
			$( "#percent" ).html( "<strong>" + prc + "</strong>" );
		
			$("#container").Progress({
				percent: prc,
				width: 900,
				animate: false
			});
			console.log(done);
		}
	});
}

setInterval( refresh, 500);

</script>