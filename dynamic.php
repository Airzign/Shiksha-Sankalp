<div id="content_news" class="content_item">
        	<h1><a href="news.php"><img src="images/news.jpg" /></a></h1>
<?php
if(!isset($news_count))
	$news_count=2;
if(!isset($impact_count))
	$impact_count=2;
if(!isset($video_count))
	$video_count=1;
$q = "SELECT * FROM news ORDER BY tm DESC LIMIT $news_count";
$r = mysql_query($q);
$entry_display ="";
$entry_display1="";
$entry_display2="";

if ( $r !== false && mysql_num_rows($r) > 0 ) {
	$entry_display='<div class="content_wrapper">';
	while ( $a = mysql_fetch_assoc($r) ) {
		$heading = stripslashes($a['heading']);
		$id = $a['id'];
        $smallimg = $a['smallimgurl'];
		if($smallimg=="" or $smallimg==null)
			$smallimg="../newsdefault.png";
		$entry_display .=<<<ENTRY_DISPLAY
			
			<br />
            <a href="news_expand.php?id=$id">
            <div class="news_item">
			<div class="news_item_img"><img src="images/news/$smallimg " width="100%" /></div>
			<div class="news_item_matter">$heading</div>
            </div>
            </a>
            <div style="clear:both"></div>

            
        

ENTRY_DISPLAY;
	}
	$entry_display=$entry_display.'</div>';
	}
	echo $entry_display;
	?>           <br />
            <a href="news.php"><p align="right">More News ....</p></a>
            
        </div>
        <div id="content_impact" class="content_item">
        	<h1><a href="impact.php"><img src="images/impact.jpg" /></a></h1>
            <br />
<?php
$q = "SELECT * FROM impact ORDER BY tm DESC LIMIT $impact_count";
    $r = mysql_query($q);

    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		$entry_display1='<div class="content_wrapper1">';
      while ( $a = mysql_fetch_assoc($r) ) {
	    $pic_desc = stripslashes($a['pic_desc']);
	    $small_desc = stripslashes($a['small_desc']);
        $smallimg = $a['smallimgurl'];
        $id = $a['id'];
		$entry_display1 .=<<<ENTRY_DISPLAY1
		<a href="impact_expand.php?id=$id">		
            <div class="news_item">
            	<div class="news_item_img"><img src="images/impact/$smallimg " width="100%" />
					<small>$pic_desc</small>
				</div>
                <div class="news_item_matter">$small_desc</div>
            </div>
        </a>
            <div style="clear:both"></div>

            
        

ENTRY_DISPLAY1;
	}
	$entry_display1=$entry_display1.'</div>';
	}
	echo $entry_display1;
	?>
			<br />
            <a href="impact.php"><p align="right">More Stories ....</p></a>
        </div>
		<div id="content_video" class="content_item_last" class="center">
			<h1>
				<a href="video.php"><img src="images/video2.jpg" /></a>
			</h1>
			<br />

<?php
$q = "SELECT * FROM video ORDER BY tm DESC LIMIT $video_count";
$r = mysql_query($q);

    if ( $r !== false && mysql_num_rows($r) > 0 ) {
      while ( $a = mysql_fetch_assoc($r) ) {
	    $heading = stripslashes($a['heading']);
	    $link = stripslashes($a['link']);
        $smallimg = $a['smallimgurl'];
		if($smallimg=="" or $smallimg==null)
			$smallimg="../videodefault.png";
		$entry_display2 .=<<<ENTRY_DISPLAY2
			$heading	<br /><br />
         <span class="center"> <a href="$link" rel="prettyPhoto" title=""><img src="images/video/$smallimg" align="absmiddle" /></a></span>
		<br />
		<br />
		<a href="video.php"><p align="right">More Videos ....</p></a>

      </div>
        </div>
    <div class="clear_all">&nbsp;</div>
 
</div>
        

ENTRY_DISPLAY2;
	}
	}
	echo $entry_display2;
	?>
