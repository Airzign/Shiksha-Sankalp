<?php
if(!isset($news_count))
  $news_count=2;
if(!isset($impact_count))
  $impact_count=2;
if(!isset($video_count))
  $video_count=1;
if(!isset($event_count))
  $event_count=0;
$entry_display ="";
$entry_display1="";
$entry_display2="";
if($news_count != 0)
{
?>
<div id="content_news" class="content_item">
  <h1>
    <a href="news.php">
      <img src="images/news.jpg" />
    </a>
  </h1>
<?php
  $q = "SELECT * FROM news ORDER BY tm DESC LIMIT $news_count";
  $r = mysql_query($q);
  if ( $r !== false && mysql_num_rows($r) > 0 ) {
    $entry_display.='<div class="content_wrapper">';
    while ( $a = mysql_fetch_assoc($r) ) {
      $heading = stripslashes($a['heading']);
      $id = $a['id'];
      $small_desc = $a['small_desc'];
      $smallimg = $a['smallimgurl'];
      $exploded_date=explode('-',$a['news_date']);
      $news_date = date("M j, Y",mktime(0,0,0,$exploded_date[1],$exploded_date[2],$exploded_date[0]));
      if($smallimg=="" or $smallimg==null)
        $smallimg="../defaults/news.png";
      $entry_display.=<<<ENTRY_DISPLAY
        <a href="news_expand.php?id=$id">
          <div class="news_item">
            <div class="news_item_img">
              <img src="images/news/$smallimg" width="100%" />
            </div>
            <div class="news_item_matter">
              $heading
              <div class="small">
                $news_date : $small_desc
              </div>
            </div>
          </div>
        </a>
ENTRY_DISPLAY;
    }
    $entry_display.="</div>";
  }
  echo $entry_display;
?>
  <a href="news.php">
    <p align="right" class="expand_link">More News ....</p>
  </a>
</div>
<?php }
if($impact_count != 0)
{
?>
<div id="content_impact" class="content_item">
  <h1>
    <a href="impact.php">
      <img src="images/impact.jpg" />
    </a>
  </h1>
<?php
  $ids_available_db=mysql_query("select id from impact");
  $ids_available=array();
  while($row=mysql_fetch_assoc($ids_available_db))
    $ids_available[]=$row['id'];
  $max_index=count($ids_available);
  $distinct_ids=array();
  if($max_index<=$impact_count)
    $distinct_ids=$ids_available;
  else {
    $count=0;
    while($count<$impact_count) {
      $random_id=$ids_available[rand(0,$max_index-1)];
      if(!in_array($random_id,$distinct_ids)) {
        $distinct_ids[]=$random_id;
        ++$count;
      }
    }
  }
  $id_string="(";
  $first_string=true;
  foreach($distinct_ids as $id) {
    if(!$first_string) {
      $id_string .= ',';
    }
    $first_string=false;
    $id_string .= $id;
  }
  $id_string.=')';
  $q = "SELECT * FROM impact where id in $id_string ORDER BY tm DESC";
  $r = mysql_query($q);
  if ( $r !== false && mysql_num_rows($r) > 0 ) {
    $entry_display1.='<div class="content_wrapper">';
    while ( $a = mysql_fetch_assoc($r) ) {
      $heading = stripslashes($a['heading']);
      $small_desc = stripslashes($a['small_desc']);
      $smallimg = $a['smallimgurl'];
      if($smallimg==null || $smallimg=="")
          $smallimg='../defaults/impact.png';
      $id = $a['id'];
      $entry_display1 .=<<<ENTRY_DISPLAY1
          <a href="impact_expand.php?id=$id">
            <div class="news_item">
              <div class="news_item_img"><img src="images/impact/$smallimg " width="100%" /></div>
              <div class="news_item_matter">$heading<br /><span class="small">$small_desc</span></div>
            </div>
          </a>
        <!--<div style="clear:both"></div>-->
ENTRY_DISPLAY1;
    }
    $entry_display1.='</div>';
  }
  echo $entry_display1;
?>
  <a href="impact.php">
    <p align="right" class="expand_link">More Stories ....</p>
  </a>
</div>
<?php } ?>
<div id="content_video">
  <h1>
    <a href="video.php">
      <img src="images/video2.jpg" />
    </a>
  </h1>
<?php
  $q = "SELECT * FROM video ORDER BY tm DESC LIMIT $video_count";
  $r = mysql_query($q);
  if ( $r !== false && mysql_num_rows($r) > 0 ) {
    while ( $a = mysql_fetch_assoc($r) ) {
      $heading = stripslashes($a['heading']);
      $link = stripslashes($a['link']);
      $description = stripslashes($a['description']);
      $smallimg = $a['smallimgurl'];
      if($smallimg=="" or $smallimg==null)
        $smallimg="../defaults/video.png";
      $entry_display2 .=<<<ENTRY_DISPLAY2
            <div class="video_item" rel="prettyPhoto" href="$link" title="$heading">
              <div class="video_heading">
                $heading
              </div>
              <div>
                 <div class="video_thumb">
                  <img src="images/video/$smallimg"/>
                </div>
                <div class="video_desc">
                  $description
                </div>
              </div>
            </div>
            <div style="clear:both;"></div>
ENTRY_DISPLAY2;
    }
    $entry_display2 .=<<<ENTRY_DISPLAY3
            <a href="video.php">
              <p align="right" class="expand_link">More Videos ....</p>
            </a>
          </div>
ENTRY_DISPLAY3;
    if($event_count>0) {
      $entry_display2 .=<<<ENTRY_DISPLAY5
          <div class="content_item_last" id="content_event">
            <h1>
              <a href="event.php">
                <img src="images/events.jpg" />
              </a>
            </h1>
ENTRY_DISPLAY5;
      $r=mysql_query("select * from event order by event_date desc limit $event_count");
      if($r !== false && mysql_num_rows($r) > 0) {
        while( $a = mysql_fetch_assoc($r)) {
          $exploded_date=explode('-',$a['event_date']);
          $event_date = date("M j, Y",mktime(0,0,0,$exploded_date[1],$exploded_date[2],$exploded_date[0]));
          $title= $a['title'];
          $id = $a['id'];
          $entry_display2 .=<<<ENTRY_DISPLAY6
            <a href="event.php?id=$id">
              <div class="event_item">
                <div class="event_date">
                  $event_date
                </div>
                <div class="event_desc">
                  $title
                </div>
              <div style="clear:both;"></div>
              </div>
            </a>
ENTRY_DISPLAY6;
        }
      }
      $entry_display2 .=<<<ENTRY_DISPLAY7
          <div class="bottomrightfloat">
            <a href="event.php">
              <p align="right" class="expand_link">More Events ....</p>
            </a>
          </div>
        </div>
ENTRY_DISPLAY7;
    }
    $entry_display2 .=<<<ENTRY_DISPLAY4
        </div>
        <div class="clear_all">&nbsp;</div>
      </div>
ENTRY_DISPLAY4;
  }
  echo $entry_display2;
?>
