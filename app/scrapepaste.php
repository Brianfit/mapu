<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
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
		
	</style>
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	<div class="container">
		<a class="navbar-brand" href="http://brian-fitzgerald.net">A Deep Div Production</a> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button> 
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active"> <a class="nav-link" href="#">Home <span class="sr-only">(current)</span> </a> </li>
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
			<div id="HeatMap">
			</div>
<!-- 
End of HTML
***************************************************************************************
Begin Script
 -->
			<script type="text/javascript">
				
				
				  // Client ID and API key from the Developer Console
				        var CLIENT_ID = '221062367563-hoajfa12orf1537ijq6l45te6n311iem.apps.googleusercontent.com';
				        var API_KEY = 'AIzaSyAvqBZcr1jg6Nav_-cgsQGRJnsf3Q3A_bg';
				        //This Key is URL restricted to use within my domain
				
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
				
				console.log(KitArray);
				console.log(KitArray.length);
				 for(let i = 0; i < KitArray.length; i++){ 
				                     listKits(KitArray[i]);
				            }
				
				   
				   }
				   
				   
				
				  function appendPre(message) {
				//         var pre = document.getElementById('MatchTable');
				//         var textContent = document.createTextNode(message + '\n');
				//         pre.appendChild(message);
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
				    console.log('listkits called '+Kit);
				    gapi.client.sheets.spreadsheets.values.get({
				      spreadsheetId: '1xlRZeP_3CrZ9J_gweVqnQfOIhdGhbr08p3zkcGQL1LE',
				      range: 'Form responses 1!A2:F',
				    }).then(function(response) {
				      var range = response.result;
				      if (range.values.length > 0) {
				
				        for (i = 0; i < range.values.length; i++) {
				          var row = range.values[i];
				          //Add conditional here -- only add the row if kit number string is present
				          if (row[2].includes(Kit) && Kit !== null & Kit !==''){
				          
				          // Print columns C and E, which correspond to indices 2 and 4.
				          //Analyze 4 split by comma and write results to an array then either
				          //increment or in some way count how many times, eg. Hopkins is mentioned
				          //to generate some form of "heat map" function so the user knows 
				          //Who recurs most frequently
				          var passengerString = row[4];
				          passengerString = stripIDK(passengerString);
				          
				          appendPre('<tr><td>'+row[2] +'</td><td>'+passengerString+'</td><td>'+row[5]+'</td></tr>');
				
				          interimArray = row[4].split(', ');
				                        console.log(interimArray);
				          interimArray.forEach(function(obj){
				  			PassengerCount.push(obj)});  
				          if (i = (range.values.length - 1)) {BooleanDone = true}
				          }
				          if (BooleanDone == true) {         //Count the occurrences of each passenger name to give a kind of "Heat map" of how frequently a particular passenger name occurs among your matches
				           
				      countPassengerMatchs();}
				        }
				      } else {
				        appendPre('No data found.');
				      }
				    }, function(response) {
				      appendPre('Error: ' + response.result.error.message);
				    });
				
				  }
				  
				  function stripIDK(passengerString){
				  passengerString = passengerString.replace(', I don\'t know','');
				  passengerString = passengerString.replace('I don\'t know','Unknown');
				  return passengerString;
				  }
				  
				   
				  function countPassengerMatchs() {
				  var counts = {};
				  for (var i = 0; i < PassengerCount.length; i++) {
				     counts[PassengerCount[i]] = 1 + (counts[PassengerCount[i]] || 0);
				       }
				//       var tag = [];     
				//       for (var e = 0; e < counts.length; e++){
				//      	   tag = 'key : '+counts[e]+' value :'
				//      } 
				     HeatMap.innerHTML = JSON.stringify(counts);
				  var tagitem = {};
				  var tag = [];
				  
				     Object.keys(counts)
				  .forEach(function eachKey(key) { 
				  tagitem = '{key : \"'+key+'\", value : '+counts[key]+'}';
				  tag.push(tagitem);
				//     alert(key); // alerts key 
				//     alert(counts[key]); // alerts value
				//     
				  });
				
				   
				
				console.log(tag);
				
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
