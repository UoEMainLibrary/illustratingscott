<?php
	include("connected.php");
		$sql = "SELECT i.recordnumber, i.imagefilename, r.worktitle, i.illustrationtitle, a.artistfirstname, a.artistlastname, e.engraverfirstname, e.engraverlastname, s.sourcetext"; 
		$sql = $sql . " FROM illustrations i, artists a, engravers e, sourcetexts s, relatedworks r";
		$sql = $sql . " where i.artists = a.id and i.engravers = e.id and i.sourcetext_id = s.id and i.relatedwork_id = r.id";
		$sql = $sql . " and i.recordnumber like \"MAG%\"";
		//echo $sql;
		$result = mysqli_query($con,$sql);
		//echo "<pre>";
		//print_r($result);
		//echo "</pre>";
		while ($row = mysqli_fetch_array($result))
		{
		//echo "<pre>";
		//print_r($row);
		//echo "</pre>";
		$recordnumber = $row['recordnumber'];
		$imagefilename = $row['imagefilename'];
		$relatedwork = $row['worktitle'];
		$illustrationtitle = $row['illustrationtitle'];
		$artist = $row['artistfirstname'] . " " . $row['artistlastname'];
		$engraver = $row['engraverfirstname'] . " " . $row['engraverlastname'];
		$sourcetext = $row['sourcetext'];
		echo "<strong>";
		echo $recordnumber;
		echo "</strong><br>\n";
		if ($imagefilename != ""){
		$itemex = explode ('#',$imagefilename);
		$imagefilename = $itemex[1];
		$imagefileno = $itemex[0];
		echo "<img src='http://illustratingscott.lib.ed.ac.uk/images/cc/wsthumbs/".$imagefileno."d.jpg'><br> \n";
		echo "image <a href='" . $imagefilename . "'>".$imagefileno."</a><br>\n";
		}
		echo "related work " . $relatedwork."<br>\n";
		echo "Illustration Title/Caption " . $illustrationtitle."<br>\n";
		echo "Artist & Engraver " . $artist;
		echo " & " . $engraver."<br>\n";
		echo "Source Text " . $sourcetext;
		echo "<br>\n<br>\n";
		}
?>
<div id="footer"><p align="center"><a href="http://www.ed.ac.uk/"><img src="images/ed2.jpg" alt="Edinburgh University Logo" border="0" /></a></p><hr />
  <p align="center" class="small blue"><strong>&copy; 2009 Project Director: Professor Peter Garside; Research Associate: Ruth M. McAdams.
<br />Co-Directors: Dr Paul Barnaby, Dr Bill Bell. <br />Project consultant: Dr Andrew Grout. <br />Database/Website Developers: Digital Library Information Systems Team.
<br /><a href="Illustrating_Scott.html">Website Accessibility Statement</a>

</strong></p>
</div>