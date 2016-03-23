<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Top News</title>
  <meta name="description" content="Demo for Uptime">
  <meta name="author" content="Rauno Kuus">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="style.css?v=2">
  
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>

<body>
<div id="header" class="container">
<h1><span id="top-text">Top</span> <span id="news-text">News</span></h1>
</div>
<div class="container">
<?php
	//get XML from provided URL
	function getXML($url){
		$xml = @simplexml_load_file($url);
		return $xml;
	}
	//get full article from Readability
	function getFullArticle($url){
		$parts = explode("url=", $url);
		$article_url = $parts[1];
		$token = '2d53df91b88f32afc3ed929af83f1474acd16bf9';
		$parser_url = 'https://www.readability.com/api/content/v1/parser?url=';
		
		$xml = @simplexml_load_file($parser_url.$article_url.'&token='.$token.'&format=xml');
		return $xml;
	}
	$rss = getXML('https://www.readability.com/rseero/latest/feed');
	
	if($rss){
	$index = 0;
	foreach($rss->channel->item as $item){
		$article = getFullArticle($item->link);
		if($article){
		?>
		<div class="col-lg-4 col-sm-6 col-xs-12">
		<div class="item-row">
		<div class="panel item-container clearfix" data-toggle="modal" data-target="#item_modal_<?php echo $index;?>">
		<?php 
		if($article->lead_image_url && $article->lead_image_url != 'None'):?>
		<img class="item-img" src="<?php echo $article->lead_image_url;?>"/>
		<?php else:?>
		<img class="item-img" src="img/image400.png"/>
		<?php endif;?>
		<div class="item-title"><?php echo $article->title;?></div>
		<div class="item-body hidden-xs"><?php echo $article->excerpt;?></div>
		<div class="item-published">Published at 
		<span><?php $d = new DateTime($item->pubDate);
		echo $d->format('d-m-Y');
		?>
		</span>
		</div>
		</div>
		</div>
		</div>
		<div class="modal" id="item_modal_<?php echo $index;?>" role="dialog">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo $article->title;?></h4>
			  </div>
			  <div class="modal-body">
				<div><?php echo $article->content;?></div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
		<?php
		}
		$index++;
	}
	}
	else{
		?>
			<h3>Nothing to display at the moment. Please come back later.</h3>
		<?php
	}
?>
</div>


<!--This is just for information-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-75415825-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>