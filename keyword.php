<?php
header('Content-Type:text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHP Ills testings</title>

<link href="stylesheets/ills.css" media="screen" rel="stylesheet" type="text/css" />
<link href="stylesheets/pagination.css" media="screen" rel="stylesheet" type="text/css" />


</head>
<body>

<?php
	include("connected.php");
	/*
	
		$sql = "SELECT keyword_id"; 
		$sql = $sql . " FROM illustrations";
		$sql = $sql . " where id = 797";
		//echo $sql;

		$result = mysqli_query($con,$sql);
		//echo "<pre>";
		//print_r($result);
		//echo "</pre>";
		while ($row = mysqli_fetch_array($result))
		{
		$keyids = $row['keyword_id'];
		echo "<pre>".$keyids."</pre>z";
		$keys = preg_replace('/\n/', '', $keyids);
		$keys = ltrim($keys, "--- - ");
		echo "<br />s: \"<pre>".$keys."\"</pre>";
		//$keyidstt = trim($keyidst, "-");
		$itemex = explode ('- ',$keys);
		//echo "<br />t: \"".$keyidst."\"";
		//echo "<br />tt: \"".$keyidstt."\"";
		//print_r($itemex);
		$keyw = "";
			foreach ($itemex as $k) {
			$sqlk = "select keyword from keywords where id = ".$k."";
			echo "<br />".$sqlk;
			$resultk = mysqli_query($con,$sqlk);
			while ($rowk = mysqli_fetch_array($resultk))
			{
			$word = $rowk['keyword'];
			$keyw = $keyw." - ".$word;
			}

		//	echo "<br>".$k;
			}
		$keyw = ltrim($keyw," -");
		echo "<br>keyw: ".$keyw;
		}
		*/
		$search = 6;
		$nopages = 12;
		$page = 12;
		$prevpage = $page - 1;
		$nextpage = $page + 1;
		echo "	    <div class=\"apple_pagination\">
      <div class=\"page_info\">        Displaying illustrations <b>26&nbsp;-&nbsp;30</b> of <b>57</b> in total
      </div>";
	echo "<div class ='pagination'>";
		if ($page == 1){
			echo "<span class=\"disabled prev_page\">&laquo; Previous</span>";
			} else {
			echo "<a href=\"/search.php?button=Related+Work+Search&amp;page=.".$prevpage."&amp;search=".$search."\" class=\"prev_page\" rel=\"prev\">&laquo; Previous</a>";
			}
		for ($x=1; $x<=$nopages; $x++)
			{

				if ($x == $page){
					echo "<span class=\"current\"> $x </span>";
				} else {
					echo "<a href=\"/search.php?button=Related+Work+Search&amp;page=".$x."&amp;search=".$search."\"> ".$x. " </a>";
					}
			}
		if ($page == $nopages){
			echo "<span class=\"disabled next_page\">&raquo; Next</span>";
			} else {
			echo "<a href=\"/search.php?button=Related+Work+Search&amp;page=.".$nextpage."&amp;search=".$search."\" class=\" next_page\" rel=\"next\">&raquo; Next</a>";
			}
		echo "</div>";		
		echo "</div>";		
		
?>

</body>
</html>