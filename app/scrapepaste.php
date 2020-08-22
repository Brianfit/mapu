<!DOCTYPE html>
<html lang="en">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-2498175-1">
	</script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		
		gtag('config', 'UA-2498175-1');
	</script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Mayflower Ancestors Gedmatch Kit Interrogator</title>
<!-- Bootstrap core CSS -->
	<link href="/bootstrap4/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
	<style>		body {
		  padding-top: 54px;
		}
	/* 
	@media (min-width: 992px) {
		  body {
		    padding-top: 56px;
		  }
		}
		img {
		  display: block;
		  max-width: 100%;
		  height: auto;
		}
 */
		ul {
		    list-style-type: none;
		     list-style-image: url('../img/mayflower25x25.png');
		}
		
		.box{
		  height: 100%;
		  width:  100%;
		  background-size: cover;
		  display: table;
		  background-attachment: fixed;
		  background-image: url('../img/Mayflower-Halsall.jpg');
		}

    .table {
   margin: auto;
   width: 70% !important; 
}
		

		
/* 
				      #wordcloud {
				        width: 1120px;
				        height: 570px;
				      }
 */



		
		
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.0.0/d3.js">
	</script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3-cloud/1.2.5/d3.layout.cloud.js">
	</script>
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	<div class="container">
		<a class="navbar-brand" href="index.html">Mayflower Ancestors Help</a> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button> 
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto">
<!-- 
            <li class="nav-item active">
              <a class="nav-link" href="#">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
 -->
				<li class="nav-item"> <a class="nav-link" href="https://www.buymeacoffee.com/brianfit">About</a> </li>
				<li class="nav-item"> <a class="nav-link" href="mailto:brianfit58@gmail.com?subject=Mayflower%20Project%20"> ﻿Contact</a> </li>
			</ul>
		</div>
	</div>
</nav>
<!-- Page Content -->
<div class="container-fluid box">
	<div class="row">
		<div class="col-sm-12 text-center align-self-center">
			<div id="errorMessages" style="margin-left:60px;margin-right:60px;">
			</div>
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_GET['ReportPage'])) {
  $Grab = $_GET['ReportPage'];


        $matches = [];
        $logs = [];
  preg_match_all('/\n\t[0-9,a-z,A-Z]+/', $Grab, $matches, PREG_UNMATCHED_AS_NULL);

  preg_match_all('/\n[[:space:]]\t[0-9,a-z,A-Z]+/', $Grab, $logs, PREG_UNMATCHED_AS_NULL);     
        $matches = array_merge($matches, $logs);
        


        $kitString = '';
        foreach ($matches as $innerArray) {
        //  Check type
        if (is_array($innerArray)){
        //  Scan through inner loop
        foreach ($innerArray as $value) {
        //             echo $value.'<br>';
            $kitString = $kitString.$value;

        }
        }else{
        // one, two, three
        echo $innerArray.'!!!!!';
        }
        }}
        ?>
        
        
        
<!-- 
End of PHP
***************************************************************************************
Begin HTML
  -->
			<br>
<!--     Content loads in this space -->
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th scope="col">Kit</th>
						<th scope="col">Passenger Ancestor(s)</th>
						<th scope="col">Certified?</th>
					</tr>
				</thead>
				<tbody id="MatchTable">
				</tbody>
			</table>
			<button id="CloudButton" style="display: none;">Cloud of Most Frequent Names</button> <button id="TableButton" style="display: none;">Table of Most Frequent Names</button> 
		</div>
	</div>
<!-- Row -->
	<div class="row">
		<div class="col-sm-12 text-center align-self-center">
			<div id="wordcloud">
			</div>
			<div id="source">
			</div>
			<div id='HeatMapTable' style="display: none; width:100%">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th scope="col">Name</th>
							<th scope="col">Number of mentions in matches</th>
						</tr>
					</thead>
					<tbody id="FrequencyTable">
					</tbody>
				</table>
			</div>
		</div>
	</div>
<!-- Row -->
</div>
<!-- Container -->
<!-- 
End of HTML
***************************************************************************************
Begin Script
 -->
<script type="text/javascript">
	
	
	  // Client ID and API key from the Developer Console
	  console.log('VARIABLE DEFINITIONS');
	 var CLIENT_ID = '122575581678-ga1b5324h5f8356bk8ovbce284e38nr7.apps.googleusercontent.com';
	var API_KEY = 'AIzaSyDAReMTbN6W4ydEFOrVGSYZCACgFuBVp6Y';
	        //This Key is URL restricted to use within my domain
	  var tags = [];
	  tags.length = 0;
	  var tagitem = {};
	              var tagString = "";
	              var counts = {};
	              counts.length = 0;
	  var KitArray = [];
	  var BooleanDone = false;
	  //Destroy any data in that array in memory
	  KitArray.length = 0;
	  var PassengerCount = [];
	  //Make sure this one is empty too 
	  PassengerCount.length = 0;
	
	  // Array of API discovery doc URLs for APIs used by the quickstart
	  var DISCOVERY_DOCS = ["https://sheets.googleapis.com/$discovery/rest?version=v4"];
	
	  // Authorization scopes required by the API; multiple scopes can be
	  // included, separated by spaces.
	  var SCOPES = "https://www.googleapis.com/auth/spreadsheets.readonly";
	
	  var authorizeButton = document.getElementById('authorize_button');
	  var signoutButton = document.getElementById('signout_button');
	  var CloudButton = document.getElementById('CloudButton');
	  var TableButton = document.getElementById('TableButton');
	  var GoodPaste = true;
	
	  /**
	   *  On load, called to load the auth2 library and API client library.
	   */
	  function handleClientLoad() {
	    gapi.load('client:auth2', initClient);
	    console.log('handleclientload executed');
	  }
	
	  /**
	   *  Parse the html pasted into the box and extract kit numbers
	   *  
	   */
	   
	   function scrapeForKits(done){
	
	     var obj = <?php echo json_encode($kitString, JSON_UNESCAPED_UNICODE); ?>;
	     var errj = <?php json_last_error_msg() ?>
	     console.log(obj);
	     console.log('yyy'+errj);
	                        var KitArray = obj.split("\t").map(function(item) {
	                        return item.trim();
	                                });
	   if (KitArray.length <= 1) { document.getElementById('errorMessages').innerHTML += '<p style="color:red">Error: Sorry, invalid data. you need to paste all or part of the table of results or the entire page called "Segment Analysis" that you get when running a kit through the GEDmatch Ancestors Project, <emphasis>Mayflower Passengers (Proven and Unproven)</emphasis>. Use the back button or <a href="https://www.brian-fitzgerald.net/mayflower-ancestors/app/?fbclid=IwAR3lFbIL9e1ab8QL9ban-tXJbCbAwx3ZkPY3USzrF_CjMgRVI7p_bKjFt2s" target="_blank">click here to return to form.</a></p>'; GoodPaste = false;}                            
		KitArray.length = Math.min(KitArray.length, 98);
		console.log('kl: '+KitArray.length);
	 for (var v = 0; v < KitArray.length; v++){ 
	                     listKits(KitArray[v]);
	
	   }  
	   return 'Done';
	   }
	   
	   
	
	  function appendWrite(message) {
	document.getElementById('MatchTable').innerHTML += message; 
	  }
	
	
	 function initClient() {
	     console.log('initClient executed'); 
	    gapi.client.init({
	      apiKey: API_KEY,
	      clientId: CLIENT_ID,
	      discoveryDocs: DISCOVERY_DOCS,
	      scope: SCOPES
	    }).then(function () {
	
	      
	      
	 // #########################################################################
	
	
	      scrapeForKits(() => BuildTable());
	
	    }, function(error) {
	      appendWrite(JSON.stringify(error, null, 2));
	    });
	  }
	
	function BuildTable(){
	Objectify(); 
	TableBuild()
	console.log('nevah evah evah');
	}
	
	function listKits(Kit) {
	    gapi.client.sheets.spreadsheets.values.get({
	      spreadsheetId: '1xlRZeP_3CrZ9J_gweVqnQfOIhdGhbr08p3zkcGQL1LE',
	      range: 'Form responses 1!A2:F',
	    }).then(function(response) {
	      var range = response.result;
	      if (range.values.length > 0) {
	
	        for (i = 0; i < range.values.length; i++) {
	
	          var row = range.values[i];
	          
	          if (row[2].includes(Kit) && Kit !== null && Kit !==''){
	          
	          // Print columns C and E, which correspond to indices 2 and 4.
	          //Analyze 4 split by comma and write results to an array then either
	          //increment or in some way count how many times, eg. Hopkins is mentioned
	          //to generate some form of "heat map" function so the user knows 
	          //Who recurs most frequently
	          var interimArray =[];
	          interimArray.length = 0;
	          var passengerString = row[4];
	          var certifiedString = row[5];
	          if (certifiedString == 'Yes'){certifiedString = '<p style="color:red;weight:strong;">Yes</p>'}
	          passengerString = stripIDK(passengerString);
	          appendWrite('<tr><td>'+row[2] +'</td><td>'+passengerString+'</td><td>'+certifiedString+'</td></tr>');
	
	
	
	          interimArray = row[4].split(', ');
	         interimArray.forEach(function(object){
	  			if (object !== "I don\'t know"){PassengerCount.push(object);}
	  			});  
	
	  			countPassengerMatchs();
	
	        				      } else {
	
	                        				      }}				      }
	    }, function(response) {
	      document.getElementById('errorMessages').innerHTML += ('<p style="color:red">Error: ' + response.result.error.message+'</p>');
	    });
	
	  };
	  
	  function stripIDK(passengerString){
	  passengerString = passengerString.replace(', I don\'t know','');
	  passengerString = passengerString.replace('I don\'t know','Unknown');
	  return passengerString;
	  }
	  
	  function countPassengerMatchs() {
				
	              counts = CountThem(PassengerCount);
	  
	}
	
	
		function CountThem(arr) {
	    var a = [], b = [], prev;
	
	    arr.sort();
	    for ( var i = 0; i < arr.length; i++ ) {
	        if ( arr[i] !== prev ) {
	            a.push(arr[i]);
	            b.push(1);
	        } else {
	            b[b.length-1]++;
	        }
	        prev = arr[i];
	    }
	
	    return [a, b];
	                
	
		}		
		
		function Objectify(){
		for (i = 0; i < counts[0].length; i++){
		tags[i] = { key : counts[0][i], value: counts[1][i] }
		}
		}
	  
			function TableBuild(){
			console.log('TableBuild');
			document.getElementById("FrequencyTable").innerHTML = '';
			
			HeatMapTable.style.display = 'block';
	
			for (var i = 0; i < counts[0].length; i++){
			var HTMLString = '<tr><td>'+counts[0][i]+'</td><td>'+counts[1][i]+'</td></tr>';
			document.getElementById("FrequencyTable").innerHTML += HTMLString;
			}
			
			}		  
	
	
	
</script>
<script>
	document.getElementById("CloudButton").addEventListener("click", function(){
					console.log("You knocked?");
	        Objectify();
	
					console.log(tags);
					CloudButton.style.display = 'none';
					TableButton.style.display = 'block';
					HeatMapTable.style.display = 'none';
					wordcloud.style.display = 'block';
					update();
					});
					
			document.getElementById("TableButton").addEventListener("click", function(){
					console.log("You knocked?");
					CloudButton.style.display = 'block';
					TableButton.style.display = 'none';
					wordcloud.style.display = 'none';
					HeatMapTable.style.display = 'block';
					TableBuild();
					});
					
			setTimeout(function(){
	    if (GoodPaste == true) {CloudButton.style.display = 'block';}
	}, 7000);
</script>
<!-- 
===================== WORDCLOUD FROM HERE ============================================
 -->
<script>
	var fill = d3.scale.category20b();
	
	// 				  var w = $("#wordcloud").innerWidth(),
	// 				    h = $("#wordcloud").innerHeight();
	var w = window.innerWidth,
	h = window.innerHeight;
	
	
	var svg_location = "#wordcloud";
	
	var fontSize;
	
	var layout = d3.layout
	.cloud()
					
					
	.rotate(0)
	.timeInterval(Infinity)
	.size([w, h])
	.fontSize(function(d) {
	  return fontSize(+d.value);
	})
	.text(function(d) {
	  return d.key;
	})
	.on("end", draw);
	
	
	    
	
	var svg = d3
	.select(svg_location)
	.append("svg")
	.attr("width", w)
	.attr("height", h);
	
	var vis = svg
	.append("g")
	.attr("transform", "translate(" + [w >> 1, h >> 1] + ")");
	
	//       update();
	
	if (window.attachEvent) {
	window.attachEvent("onresize", update);
	} else if (window.addEventListener) {
	window.addEventListener("resize", update);
	}
	
	function draw(data, bounds) {
	var w = window.innerWidth,
	  h = window.innerHeight;
	
	$("#wordcloud").innerWidth = w;
	$("#wordcloud").index = h;
	//   ***
	svg.remove();
	svg = d3
	  .select(svg_location)
	  .append("svg")
	  .attr("width", w)
	  .attr("height", h);
	
	vis = svg
	  .append("g")
	  .attr("transform", "translate(" + [w >> 1, h >> 1] + ")");
	//   ***
	
	svg.attr("width", w).attr("height", h);
	
	var scale = bounds
	  ? Math.min(
	      w / Math.abs(bounds[1].x - w / 2),
	      w / Math.abs(bounds[0].x - w / 2),
	      h / Math.abs(bounds[1].y - h / 2),
	      h / Math.abs(bounds[0].y - h / 2)
	    ) / 2
	  : 1;
	
	var text = vis.selectAll("text").data(data, function(d) {
	  return d.text.toLowerCase();
	});
	text
	  .transition()
	  .duration(1000)
	  .attr("transform", function(d) {
	    return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
	  })
	  .style("font-size", function(d) {
	    return d.size + "px";
	  });
	text
	  .enter()
	  .append("text")
	  .attr("text-anchor", "middle")
	  .attr("transform", function(d) {
	    return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
	  })
	  .style("font-size", function(d) {
	    return d.size + "px";
	  })
	  .style("opacity", 1e-6)
	  .transition()
	  .duration(1000)
	  .style("opacity", 1);
	text
	  .style("font-family", function(d) {
	    return d.font;
	  })
	  .style("fill", function(d) {
	    return fill(d.text.toLowerCase());
	  })
	  .text(function(d) {
	    return d.text;
	  });
	
	vis
	  .transition()
	  .attr(
	    "transform",
	    "translate(" + [w >> 1, h >> 1] + ")scale(" + scale + ")"
	  );
	}
	
	function update() {
	console.log("update called");
	console.log('size: '+w+' by '+h);
	layout.font("impact").spiral("rectangular");
	fontSize = d3.scale["sqrt"]().range([20, 40]);
	
	if (tags.length) {
	  fontSize.domain([+tags[tags.length - 1].value || 1, +tags[0].value]);
	}
	layout
	  .stop()
	  .words(tags)
	  .start();
	}
	
	function changeWords(newTags) {
	tags = newTags;
	update();
	}
</script>
<!-- Bootstrap core JavaScript -->
<script src="/bootstrap4/js/jquery.min.js">
</script>
<script src="/bootstrap4/js/bootstrap.bundle.min.js">
</script>
<script async defer src="https://apis.google.com/js/api.js" onload="this.onload=function(){};handleClientLoad()" onreadystatechange="if (this.readyState === 'complete') this.onload()">
</script>
</body>
</html>
