<?php
header('Content-Type:text/html; charset=UTF-8');

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Illustrating Scott: Item Details</title>

<link href="stylesheets/ills.css" media="screen" rel="stylesheet" type="text/css" />
<link href="stylesheets/pagination.css" media="screen" rel="stylesheet" type="text/css" />
<script src="openseadragon/openseadragon.min.js"></script>

</head>
<body>
<div id="maincontainer">

<div id="topsection"><div class="innertube"><a href="index.html"><img src="images/saxon3.jpg" alt="logo"border="0"></a><span class="paleblue htext">Illustrating Scott</span></div>
   <div class="paleblueback"> <a href='index.html'>Home</a> | <a href='query.html'>Searching &amp; Browsing</a> | <a href="guide.html">Guide</a> | <a href="credits.html">Credits</a> | <a href="links.html">Links</a> | <a href="sitemap.html">Sitemap</a> | <a href="contacts.html">Contacts</a></div>
 </div>

<div id="contentwrapper">
<div id="contentcolumn">
<div class="innertube">
<p style="color: green"></p>	
	
<?php
	include("connected.php");
	$illsid = $_GET['id'];
        // die if illusid is not a number - probable hack attempt
	if(!is_numeric($illsid)) {
           die();
        }
	// ** gets keyword ids from illustrations table, splits into separate values, iterates to retrieve keyword names - builds into a string for display later.
	//echo "<p>".$illsid."</p>";
		$sql = "SELECT keyword_id"; 
		$sql = $sql . " FROM illustrations";
		$sql = $sql . " where id = ".$illsid."";
		//echo $sql;
		
		// MikeB injection fix Sep 2020
		$sqle = mysqli_real_escape_string($con, $sql);
		$result = mysqli_query($con,$sqle);

		while ($row = mysqli_fetch_array($result))
		{
		$keyids = $row['keyword_id'];

		// ** tidying value before split
		$keys = preg_replace('/\n/', '', $keyids);
		$keys = ltrim($keys, "--- - ");
		// ** splits string
		$itemex = explode ('- ',$keys);
		$keyw = "";
			// ** iterates through split array
			foreach ($itemex as $k) {
			$sqlk = "select keyword from keywords where id = ".$k."";
		//	echo "<br />".$sqlk;
			$resultk = mysqli_query($con,$sqlk);
			while ($rowk = mysqli_fetch_array($resultk))
			{
			// ** builds string to be used in display below
			$word = $rowk['keyword'];
			$keyw = $keyw." - ".$word;
			}

			}
		$keyw = ltrim($keyw," -");
		//echo "<br>keyw: ".$keyw;
		
		
		}
		//mysqli_close($con);
		
		
		$sql = "SELECT i.id, i.recordnumber, i.imagefilename, w.worktype, i.notes, i.locationofcopy, i.positioninsourcetext, i.startdate, i.size, r.worktitle, i.illustrationtitle, a.artistfirstname, a.artistlastname, e.engraverfirstname, e.engraverlastname, s.sourcetext";
		$sql = $sql . " FROM illustrations i, artists a, engravers e, sourcetexts s, relatedworks r, worktypes w";
		$sql = $sql . " where i.artists = a.id and i.engravers = e.id and i.sourcetext_id = s.id and i.relatedwork_id = r.id and i.worktype = w.id";
		$sql = $sql . " and i.id = ".$illsid."";
		//echo $sql;
		// MikeB injection fix Sep 2020
		$sqle = mysqli_real_escape_string($con, $sql);
		$resu = mysqli_query($con,$sqle);

		while ($row = mysqli_fetch_array($resu))
		{
		$recordnumber = $row['recordnumber'];
		$relatedwork = $row['worktitle'];
		$illustrationtitle= $row['illustrationtitle'];
		$artist = $row['artistfirstname']. " " . $row['artistlastname'];
		$engraver = $row['engraverfirstname'] . " " . $row['engraverlastname'];
		$worktype = $row['worktype'];
		$size = $row['size'];
		$startdate = $row['startdate'];
		$sourcetext = $row['sourcetext'];
		$positioninsourcetext = $row['positioninsourcetext'];
		$locationofcopy = $row['locationofcopy'];
		$imagefilename = $row['imagefilename'];
		$notes= $row['notes'];
?>


<p>
  <strong class="bluetext">Record Number:</strong>
<?php echo $recordnumber; ?>
</p>

<p>
  <strong class="bluetext">Related Work:</strong>
<?php echo $relatedwork; ?>
</p>

<p>
  <strong class="bluetext">Illustration Title/Caption:</strong>
<?php echo $illustrationtitle; ?>
</p>

<p>
  <strong class="bluetext">Keyword(s):</strong>
<?php echo $keyw;?>
</p>

<p>
  <strong class="bluetext">Artist:</strong>
<?php echo $artist; ?>
</p>

<p>
  <strong class="bluetext">Engraver:</strong>
<?php echo $engraver; ?>
</p>

<p>
  <strong class="bluetext">Work Type:</strong>
<?php echo $worktype; ?>
</p>

<p>
  <strong class="bluetext">Size(cm):</strong>
<?php echo $size; ?>
</p>

<p>
  <strong class="bluetext">Date:</strong>
<?php echo $startdate; ?>
</p>



<p>
  <strong class="bluetext">Source Text:</strong>
<?php echo $sourcetext; ?>
</p>

<p>
  <strong class="bluetext">Position in Source Text:</strong>
<?php echo $positioninsourcetext; ?>
</p>

<p>
  <strong class="bluetext">Location of Copy:</strong>
<?php echo $locationofcopy; ?>
</p>

<p>
  <strong class="bluetext">Image File Name:</strong>
  <?php 
  		if ($imagefilename != ""){
		$itemex = explode ('#',$imagefilename);
		$imagefilename = $itemex[1];
		$imagefileno = $itemex[0];
		echo "<a href='" . $imagefilename . "'>".$imagefileno."</a>";
		} else {
		echo "No image available for this record.";
		}
		
   ?>
</p>



  <br />

  
 
  
    





<p>
  <strong class="bluetext">Notes:</strong>
<?php echo $notes; ?>
</p>
<?php } ?>
<a href="javascript: history.go(-1)"><< Back</a>

 

	
</div>
</div>
</div>


  <div id="rightcolumn">
<div class="innertube" align="center">
	<?php
		if ($imagefilename != ""){
		preg_match('/UoEwal.*/',$imagefilename,$mat);
		$linkURI = $imagefilename;
//		echo "<p>$linkURI</p>";
		$tileSource = str_replace('detail', 'iiif', $linkURI) . '/info.json';

               $iiifmax = str_replace('info.json', 'full/full/0/default.jpg', $tileSource);

               list($width, $height) = getimagesize($iiifmax);

               //echo 'WIDTH'.$width.'HEIGHT'.$height

               $portrait = true;

               if ($width > $height) {

                   $portrait = false;

               }

               $mainImage = false;

               $json = file_get_contents($tileSource);

               $jobj = json_decode($json, true);

               $error = json_last_error();

               $jsoncontext = $jobj['@context'];

               $jsonid = $jobj['@id'];

               $jsonheight = $jobj['height'];

               $jsonwidth = $jobj['width'];

               $jsonprotocol = $jobj['protocol'];

               $jsontiles = $jobj['tiles'];

               $jsonprofile = $jobj['profile'];
		?>
		<div class="full-image">

                       <div id="openseadragon">

                           <script type="text/javascript">

                               OpenSeadragon({

                                   id: "openseadragon",

                                   prefixUrl: "http://illustratingscott.lib.ed.ac.uk/openseadragon/images/",

                                   preserveViewport: true,

                                   visibilityRatio: 1,

                                   minZoomLevel: 0.7,

                                   defaultZoomLevel: 0,

                                   panHorizontal: true,

                                   sequenceMode: true,

                                   tileSize: 750,

                                   tileSources: [{

                                       "@context": "<?php echo $jsoncontext ?>",

                                       "@id": "<?php echo $jsonid ?>",

                                       "height": <?php echo $jsonheight ?>,

                                       "width": <?php echo $jsonwidth ?>,

                                       "profile": ["http://iiif.io/api/image/2/level2.json",

                                           {

                                               "formats": ["gif", "pdf"]

                                           }

                                       ],

                                       "protocol": "<?php echo $jsonprotocol ?>",

                                       "tiles": [{

                                           "scaleFactors": [1, 2, 8, 16, 32],

                                           "width": 512

                                       }]

                                       //minLevel: 2

                                   }]

                               });

                           </script>

                       </div>

                   </div>
		<?php

		}
      ?>
     <p><a href="http://www.britac.ac.uk/"><img src="images/bacademy.jpg" border="0" alt="british academy logo" /></a></p>
</div>

</div>   

<div id="footer"><p align="center"><a href="http://www.ed.ac.uk/"><img src="images/ed2.jpg" alt="Edinburgh University Logo" border="0" /></a></p><hr />
  <p align="center" class="small blue"><strong>&copy; 2009 Project Director: Professor Peter Garside; Research Associate: Ruth M. McAdams.
<br />Co-Directors: Dr Paul Barnaby, Dr Bill Bell. <br />Project consultant: Dr Andrew Grout. <br />Database/Website Developers: Digital Library Information Systems Team.
<br /><a href="Illustrating_Scott.html">Website Accessibility Statement</a>

</strong></p>
</div>

</div>
</body>
</html>
	
