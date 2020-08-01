<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Bare - Brian's Start Bootstrap Template</title>

<!-- Bootstrap core CSS -->
	<link href="/bootstrap4/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
	<style>		body {
		         padding-top: 54px;
		       }
		       @media (min-width: 992px) {
		         body {
		           padding-top: 56px;
		         }
		       }
		          
		      #wordcloud {
		        width: 1300px;
		        height: 500px;
		      }


		   
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
		<a class="navbar-brand" href="http://brian-fitzgerald.net">A Deep Div Production</a> 
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active"> <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> </li>
				<li class="nav-item"> <a class="nav-link" href="https://www.buymeacoffee.com/brianfit">About</a> </li>
				<li class="nav-item"> <a class="nav-link" mailto="brianfit58@gmail.com">Contact</a> </li>
			</ul>
		</div>
	</div>
</nav>
<!-- Page Content -->
<div class="container">


	<div class="row">
		<div class="col-lg-12 text-center">

<?php 

        $matches = [];
        preg_match_all('/\n\t[0-9,a-z,A-Z]+/', $_GET['ReportPage'], $matches, PREG_UNMATCHED_AS_NULL);

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
        }
        ?>
<!-- 
End of PHP
***************************************************************************************
Begin HTML
  -->
			<br>
<!-- 
 These buttons are artefacts of the authorisation process and are not shown (display set to none further down)
 -->
			<button id="authorize_button" style="display: none;">Authorize</button> <button id="signout_button" style="display: none;">Sign Out</button> 


<!--     Content loads in this space -->

			<table class="table table-striped table-bordered table-dark">
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
			<pre id="content" style="white-space: pre-wrap;">
                        
			</pre>
			
	<button id="CloudButton" style="display: block;">Cloud of Most Frequent Names</button> <button id="TableButton" style="display: none;">Table of Most Frequent Names</button> 
		<div id="wordcloud"></div>
    <div id="source"></div>





<!-- 
End of HTML
***************************************************************************************
Begin Script
 -->
			<script type="text/javascript">
				
				
				  // Client ID and API key from the Developer Console
				  console.log('VARIABLE DEFINISTIONS');
				 var CLIENT_ID = '221062367563-hoajfa12orf1537ijq6l45te6n311iem.apps.googleusercontent.com';
				var API_KEY = 'AIzaSyAvqBZcr1jg6Nav_-cgsQGRJnsf3Q3A_bg';
				        //This Key is URL restricted to use within my domain
				  var tags = [];
				  var tagitem = {};
				              var tagString = "";
				              var counts = {};
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
				   
				   function scrapeForKits(){
				
				     var obj = <?php echo json_encode($kitString); ?>;
				                        var KitArray = obj.split("\t").map(function(item) {
				                        return item.trim();
				                                });

				 for (var v = 0; v < KitArray.length; v++){ 
				                     listKits(KitArray[v]);}
				            
				   
				   }
				   
				   
				
				  function appendPre(message) {
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
				      // Listen for sign-in state changes.
				      gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);
				      document.getElementById('content').innerHTML ="";
				      // Scrape the kit numbers from the data you get from the form, then list the kits they match in the spreadsheet. Write the passenger names to an array called PassengerCount
				      
				      
				 // #############################################################################

				
				      scrapeForKits();

				      

				      
				
				      // Handle the initial sign-in state.
				      updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
				      authorizeButton.onclick = handleAuthClick;
				      signoutButton.onclick = handleSignoutClick;
				    }, function(error) {
				      appendPre(JSON.stringify(error, null, 2));
				    });
				  }
				
				  /**
				   *  Called when the signed in status changes, to update the UI
				   *  appropriately. After a sign-in, the API is called.
				   */
				  function updateSigninStatus(isSignedIn) {
				    if (isSignedIn) {
				      authorizeButton.style.display = 'none';
				      //changed from 'block' 
				      signoutButton.style.display = 'none';      
				    } else {
				    //changed from 'block'
				      authorizeButton.style.display = 'none';
				      signoutButton.style.display = 'none';
				    }
				  }
				
				  /**
				   *  Sign in the user upon button click.
				   */
				  function handleAuthClick(event) {
				    gapi.auth2.getAuthInstance().signIn();
				  }
				
				  /**
				   *  Sign out the user upon button click.
				   */
				  function handleSignoutClick(event) {
				    gapi.auth2.getAuthInstance().signOut();
				  }
				
				
				// to here
				
function listKits(Kit) {
				    gapi.client.sheets.spreadsheets.values.get({
				      spreadsheetId: '1xlRZeP_3CrZ9J_gweVqnQfOIhdGhbr08p3zkcGQL1LE',
				      range: 'Form responses 1!A2:F',
				    }).then(function(response) {
				      var range = response.result;
				      if (range.values.length > 0) {
				
				        for (i = 0; i < range.values.length; i++) {
// 				        console.log('i = '+i+' range = '+range.values.length);
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
				          passengerString = stripIDK(passengerString);
				          appendPre('<tr><td>'+row[2] +'</td><td>'+passengerString+'</td><td>'+row[5]+'</td></tr>');

// 							PassengerCount.push(row[4].split(', '));
				
				          interimArray = row[4].split(', ');
				         interimArray.forEach(function(object){
				  			PassengerCount.push(object);
				  			});  

				  			countPassengerMatchs();

				        				      } else {
				       //  appendPre('No data found.');
                        				      }}				      }
				    }, function(response) {
				      appendPre('Error: ' + response.result.error.message);
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
  
				  
				
				
				
			</script>
			<script>
        document.getElementById("CloudButton").addEventListener("click", function(){
				console.log("You knocked?");
                Objectify();
				update();
				console.log(tags);
				});
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
				fontSize = d3.scale["sqrt"]().range([15, 30]);
				//         var tags = [
				//           { key: "Cat in the hat", value: 26 },
				//           { key: "fish leonard", value: 19 },
				//           { key: "things that go bump", value: 18 },
				//           { key: "look", value: 16 },
				//           { key: "two", value: 15 },
				//           { key: "like", value: 14 },
				//           { key: "hat", value: 14 },
				//           { key: "Oh", value: 13 },
				//           { key: "mother", value: 12 },      
				//           { key: "One", value: 12 },
				//           { key: "Now", value: 12 },
				//           { key: "Thing", value: 12 },
				//           { key: "house", value: 10 },
				//           { key: "fun", value: 9 },
				//           { key: "know", value: 9 },
				//           { key: "good", value: 9 },
				//           { key: "saw", value: 9 },
				//           { key: "bump", value: 8 },
				//           { key: "hold", value: 7 },
				//           { key: "fear", value: 6 },
				//           { key: "game", value: 6 },
				//           { key: "play", value: 6 },
				//           { key: "Sally", value: 6 },
				//           { key: "wet", value: 6 },
				//           { key: "little", value: 6 },
				//           { key: "box", value: 6 },
				//           { key: "came", value: 6 },
				//           { key: "away", value: 6 },
				//           { key: "sit", value: 5 },
				//           { key: "ran", value: 5 },
				//           { key: "big", value: 5 },
				//           { key: "something", value: 5 },
				//           { key: "put", value: 5 },
				//           { key: "fast", value: 5 },
				//           { key: "go", value: 5 },
				//           { key: "ball", value: 5 },
				//           { key: "pot", value: 5 },
				//           { key: "show", value: 4 },
				//           { key: "cup", value: 4 },
				//           { key: "get", value: 4 },
				//           { key: "cake", value: 4 },
				//           { key: "pick", value: 4 },
				//           { key: "went", value: 4 },
				//           { key: "toy", value: 4 },
				//           { key: "ship", value: 4 },
				//           { key: "net", value: 4 },
				//           { key: "tell", value: 4 },
				//           { key: "fan", value: 4 },
				//           { key: "wish", value: 4 },
				//           { key: "day", value: 4 },
				//           { key: "new", value: 4 },
				//           { key: "tricks", value: 4 },
				//           { key: "way", value: 4 },
				//           { key: "sat", value: 4 },
				//           { key: "books", value: 3 },
				//           { key: "hook", value: 3 },
				//           { key: "mess", value: 3 },
				//           { key: "kites", value: 3 },
				//           { key: "rake", value: 3 },
				//           { key: "red", value: 3 },
				//           { key: "shame", value: 3 },
				//           { key: "bit", value: 3 },
				//           { key: "hands", value: 3 },
				//           { key: "gown", value: 3 },
				//           { key: "call", value: 3 },
				//           { key: "cold", value: 3 },
				//           { key: "fall", value: 3 },
				//           { key: "milk", value: 3 },
				//           { key: "shook", value: 3 },
				//           { key: "tame", value: 2 },
				//           { key: "deep", value: 2 },
				//           { key: "Sank", value: 2 },
				//           { key: "head", value: 2 },
				//           { key: "back", value: 2 },
				//           { key: "fell", value: 2 },
				//           { key: "hop", value: 2 },
				//           { key: "shut", value: 2 },
				//           { key: "dish", value: 2 },
				//           { key: "trick", value: 2 },
				//           { key: "take", value: 2 },
				//           { key: "tip", value: 2 },
				//           { key: "top", value: 2 },
				//           { key: "see", value: 2 },
				//           { key: "let", value: 2 },
				//           { key: "shake", value: 2 },
				//           { key: "bad", value: 2 },
				//           { key: "another", value: 2 },
				//           { key: "come", value: 2 },
				//           { key: "fly", value: 2 },
				//           { key: "want", value: 2 },
				//           { key: "hall", value: 2 },
				//           { key: "wall", value: 2 },
				//           { key: "Thump", value: 2 },
				//           { key: "Make", value: 2 },
				//           { key: "lot", value: 2 },
				//           { key: "hear", value: 2 },
				//           { key: "find", value: 2 },
				//           { key: "lots", value: 2 },
				//           { key: "bet", value: 2 },
				//           { key: "dear", value: 2 },
				//           { key: "looked", value: 2 },
				//           { key: "gone", value: 2 },
				//           { key: "sun", value: 2 },
				//           { key: "asked", value: 1 },
				//           { key: "shine", value: 1 },
				//           { key: "mind", value: 1 },
				//           { key: "bite", value: 1 },
				//           { key: "step", value: 1 },
				//           { key: "mat", value: 1 },
				//           { key: "gave", value: 1 },
				//           { key: "pat", value: 1 },
				//           { key: "bent", value: 1 },
				//           { key: "funny", value: 1 },
				//           { key: "give", value: 1 },
				//           { key: "games", value: 1 },
				//           { key: "high", value: 1 },
				//           { key: "hit", value: 1 },
				//           { key: "run", value: 1 },
				//           { key: "stand", value: 1 },
				//           { key: "fox", value: 1 },
				//           { key: "man", value: 1 },
				//           { key: "string", value: 1 },
				//           { key: "kit", value: 1 },
				//           { key: "Mothers", value: 1 },
				//           { key: "tail", value: 1 },
				//           { key: "dots", value: 1 },
				//           { key: "pink", value: 1 },
				//           { key: "white", value: 1 },
				//           { key: "kite", value: 1 },
				//           { key: "bed", value: 1 },
				//           { key: "bumps", value: 1 },
				//           { key: "jumps", value: 1 },
				//           { key: "kicks", value: 1 },
				//           { key: "hops", value: 1 },
				//           { key: "thumps", value: 1 },
				//           { key: "kinds", value: 1 },
				//           { key: "book", value: 1 },
				//           { key: "home", value: 1 },
				//           { key: "wood", value: 1 },
				//           { key: "hand", value: 1 },
				//           { key: "near", value: 1 },
				//           { key: "Think", value: 1 },
				//           { key: "rid", value: 1 },
				//           { key: "made", value: 1 },
				//           { key: "jump", value: 1 },
				//           { key: "yet", value: 1 },
				//           { key: "PLOP", value: 1 },
				//           { key: "last", value: 1 },
				//           { key: "stop", value: 1 },
				//           { key: "pack", value: 1 },
				//           { key: "nothing", value: 1 },
				//           { key: "got", value: 1 },
				//           { key: "sad", value: 1 },
				//           { key: "kind", value: 1 },
				//           { key: "fishHe", value: 1 },
				//           { key: "sunny", value: 1 },
				//           { key: "Yes", value: 1 },
				//           { key: "bow", value: 1 },
				//           { key: "tall", value: 1 },
				//           { key: "always", value: 1 },
				//           { key: "playthings", value: 1 },
				//           { key: "picked", value: 1 },
				//           { key: "strings", value: 1 },
				//           { key: "Well", value: 1 },
				//           { key: "lit", value: 1 }
				//         ];
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
		</div>
	</div>
</div>
<!-- Bootstrap core JavaScript -->
<script src="/bootstrap4/js/jquery.min.js">
</script>
<script src="/bootstrap4/js/bootstrap.bundle.min.js">
</script>
<script async defer src="https://apis.google.com/js/api.js" onload="this.onload=function(){};handleClientLoad()" onreadystatechange="if (this.readyState === 'complete') this.onload()">
</script>
</body>
</html>
