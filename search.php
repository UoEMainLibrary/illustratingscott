<?php
header('Content-Type:text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Illustrating Scott: Search Results</title>

<link href="stylesheets/ills.css" media="screen" rel="stylesheet" type="text/css" />
<link href="stylesheets/pagination.css" media="screen" rel="stylesheet" type="text/css" />


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
	$simpleterm = mysqli_real_escape_string($con,$_GET['search']);
	//$simpleterm = $_GET['search'];
	$keywordid = mysqli_real_escape_string($con,$_GET['keysearch'] ?? '');
	$titles = mysqli_real_escape_string($con,$_GET['titlesearch'] ?? '');
	$dates = mysqli_real_escape_string($con,$_GET['datesearch'] ?? '');
	$relateds = mysqli_real_escape_string($con,$_GET['relatedworksearch'] ?? '');
	$artists = mysqli_real_escape_string($con,$_GET['artistsearch'] ?? '');
	$engravers = mysqli_real_escape_string($con,$_GET['engraversearch'] ?? '');
	$sourcetexts = mysqli_real_escape_string($con,$_GET['sourcetextsearch'] ?? '');
	$count = 0;
	//echo "search: ".$simpleterm."<br>";
	//echo "keysearch: ".$keywordid."<br>";
	
	//echo "<p>".$simpleterm."</p>";
	
		$sql = "SELECT i.id, i.recordnumber, i.imagefilename, i.notes, i.startdate, r.worktitle, i.illustrationtitle, a.artistfirstname, a.artistlastname, e.engraverfirstname, e.engraverlastname, s.sourcetext"; 
		$sql = $sql . " FROM illustrations i, artists a, engravers e, sourcetexts s, relatedworks r";
		$sql = $sql . " where i.artists = a.id and i.engravers = e.id and i.sourcetext_id = s.id and i.relatedwork_id = r.id";
		// ** if it's a general simple search
		if (isset($simpleterm)) {
		$sql = $sql . " and (i.illustrationtitle like \"%".$simpleterm."%\"";
		$sql = $sql . " or a.artistfirstname like \"%".$simpleterm."%\"";
		$sql = $sql . " or a.artistlastname like \"%".$simpleterm."%\"";
		$sql = $sql . " or e.engraverfirstname like \"%".$simpleterm."%\"";
		$sql = $sql . " or engraverlastname like \"%".$simpleterm."%\"";
		$sql = $sql . " or i.notes like \"%".$simpleterm."%\"";
		$sql = $sql . " or s.sourcetext like \"%".$simpleterm."%\"";
		$sql = $sql . " or r.worktitle like \"%".$simpleterm."%\")";
		$searchterm = $simpleterm;
		$searchtype = "search";
		}
		
		// ** if it' s a keyword search
		if (isset($keywordid) && $keywordid != ''){
		$sql = $sql . " and keyword_id like \"%\\\"".$keywordid."\\\"%\"";
		$searchterm = $keywordid;
		$searchtype = "keysearch";
		}
		
		// ** if it's a title search
		if (isset($titles) && $titles != ''){
		$sql = $sql . " and i.illustrationtitle like \"%".$titles."%\"";
		$searchterm = $titles;
		$searchtype = "titlesearch";
		}
		
		// ** if it's a date search (YYYY)
		if (isset($dates) && $dates != ''){
		$sql = $sql . " and i.startdate = ".$dates."";
		$searchterm = $dates;
		$searchtype = "datesearch";
		}		
		
		// ** if it's a related work search
		if (isset($relateds) && $relateds != ''){
		$sql = $sql . " and i.relatedwork_id = ".$relateds."";
		$searchterm = $relateds;
		$searchtype = "relatedworksearch";
		}		
		
		// ** if it's an artist search
		if (isset($artists) && $artists != ''){
		$sql = $sql . " and a.id = ".$artists."";
		$searchterm = $artists;
		$searchtype = "artistsearch";
		}
				
		// ** if it's an engraver search
		if (isset($engravers) && $engravers != ''){
		$sql = $sql . " and e.id = ".$engravers."";
		$searchterm = $engravers;
		$searchtype = "engraversearch";
		}
				
		// ** if it's a sourcetext search
		if (isset($sourcetexts) && $sourcetexts != ''){
		$sql = $sql . " and s.id = ".$sourcetexts."";
		$searchterm = $sourcetexts;
		$searchtype = "sourcetextsearch";
		}
		
		// ** ordering sql result
		$sql = $sql . " order by i.relatedwork_id, i.startdate ASC";
		
		
		//echo $sql;

		
		// ** get count of rows for pagination purposes
		if ($stmt = mysqli_prepare($con, $sql)) {
		
		    /* execute query */
		    mysqli_stmt_execute($stmt);
		
		    /* store result */
		    mysqli_stmt_store_result($stmt);
		
		    $count = mysqli_stmt_num_rows($stmt);
		
		    /* close statement */
		    mysqli_stmt_close($stmt);
		}
		
		$offset = 5;
		$nopages = ceil($count / $offset);
		if (isset($_GET['page'])){
		$page = $_GET['page'];
		} else {
		$page = 1;
		}
		$prevpage = $page - 1;
		$nextpage = $page + 1;
		$bottom = $prevpage * $offset;
		$itemfirst = $bottom + 1;
		$itemlast = $page * $offset;
		if ($itemlast > $count){
		$itemlast = $count;
		}
		
		// ** for pagination
		$sql = $sql . " LIMIT $offset offset $bottom";
		
		// ** calling query
		$result = mysqli_query($con,$sql);

		
		
		echo "	    <div class=\"apple_pagination\">
      <div class=\"page_info\">";
      if ($count < 6) {
      	if ($count < 2) {
       echo "Displaying <strong>".$count."</strong> illustration<br />";
      	} else {
       echo "Displaying all <strong>".$count."</strong> illustrations<br />";
       	}
       } else {
       echo "Displaying illustrations <strong>$itemfirst - $itemlast</strong> of <strong>".$count."</strong> in total"; 
      }
      echo "</div>\n";
      echo "<div class=\"pagination\">";
      if ($page == 1){
			echo "<span class=\"disabled prev_page\">&laquo; Previous</span>";
			} else {
			echo "<a href=\"search.php?button=Search&amp;page=".$prevpage."&amp;$searchtype=".$searchterm."\" class=\"prev_page\" rel=\"prev\">&laquo; Previous</a>";
			}
		for ($x=1; $x<=$nopages; $x++)
			{

				if ($x == $page){
					echo "<span class=\"current\"> $x </span>";
				} else {
					echo "<a href=\"search.php?button=Search&amp;page=".$x."&amp;$searchtype=".$searchterm."\"> ".$x. " </a>";
					}
			}
		if ($page == $nopages){
			echo "<span class=\"disabled next_page\">Next &raquo;</span>";
			} else {
			echo "<a href=\"search.php?button=Search&amp;page=".$nextpage."&amp;$searchtype=".$searchterm."\" class=\" next_page\" rel=\"next\">Next &raquo;</a>";
			}
		echo "\n</div>\n</div>";
      		echo "<h1>Search Results</h1>";
?>

<?php



		while ($row = mysqli_fetch_array($result))
		{
		$illid = $row['id'];
		$recordnumber = $row['recordnumber'];
		$imagefilename = $row['imagefilename'];
		$relatedwork = $row['worktitle'];
		$illustrationtitle = $row['illustrationtitle'];
		$artist = $row['artistfirstname'] . " " . $row['artistlastname'];
		$engraver = $row['engraverfirstname'] . " " . $row['engraverlastname'];
		$sourcetext = $row['sourcetext'];
		
		// ** Begin display of illustrations
		
		echo "<p class=\"title bold\" align=\"center\">Record Number: ";
		echo $recordnumber;
		echo "</p>\n";
		echo " <table> <tr valign=\"top\">";
		if ($imagefilename != ""){
		preg_match('/UoEwal.*/',$imagefilename,$mat);
		
		$itemex = explode ('#',$imagefilename);
		$imagefilename = $itemex[1];
		$imagefileno = $itemex[0];
		echo "<td>\n<div id=\"imagepos\" align=\"center\"><!--<img src='images/cc/wsthumbs/".$imagefileno."'>--><img src='http://images.is.ed.ac.uk/luna/servlet/iiif/$mat[0]/full/192,/0/default.jpg'</div>\n</td> \n";
		//echo "image <a href='" . $imagefilename . "'>".$imagefileno."</a><br>\n";
		}
		echo "<td>";
		echo "<p><strong>Related Work:</strong> " . $relatedwork."</p>\n";
		echo "<p><strong>Illustration Title/Caption:</strong> " . $illustrationtitle."</p>\n";
		echo "<p><strong>Artist & Engraver:</strong> " . $artist;
		if ($engraver != " "){
		echo " & " . $engraver;
		}
		echo "</p>\n";
		echo "<p><strong>Source Text:</strong> " . $sourcetext."</p>";
		echo "<p><a href=\"itemshow.php?id=".$illid."\">Show</a></p>";
		echo "</td>\n</tr>\n";
		echo "</table><br />\n";
		echo "<hr width=\"20%\" />\n";
		}
?>




    
    
<div class="apple_pagination">

<?php 
		if ($nopages > 1) {
echo "<div class=\"pagination\">";
      if ($page == 1){
			echo "<span class=\"disabled prev_page\">&laquo; Previous</span>";
			} else {
			echo "<a href=\"search.php?button=Search&amp;page=".$prevpage."&amp;$searchtype=".$searchterm."\" class=\"prev_page\" rel=\"prev\">&laquo; Previous</a>";
			}
		for ($x=1; $x<=$nopages; $x++)
			{

				if ($x == $page){
					echo "<span class=\"current\"> $x </span>";
				} else {
					echo "<a href=\"search.php?button=Search&amp;page=".$x."&amp;$searchtype=".$searchterm."\"> ".$x. " </a>";
					}
			}
		if ($page == $nopages){
			echo "<span class=\"disabled next_page\">Next &raquo;</span>";
			} else {
			
			echo "<a href=\"search.php?button=Search&amp;page=".$nextpage."&amp;$searchtype=".$searchterm."\" class=\" next_page\" rel=\"next\">Next &raquo;</a>";
			}
		echo "\n</div>";
		}
?>
</div>

	
</div>
</div>
</div>


  <div id="rightcolumn">
<div class="innertube">
	<br />

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
	
