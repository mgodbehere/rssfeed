<!doctype html>
<html>
<head>
	<title>RSS Feed Reader</title>
	<!-- Bootstrap & Icons links -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

	<?php
	// check if input has been set then do something
	if(isset($_POST['url']))
	{
		$url = $_POST['url'];
		@$rss = simplexml_load_file($url); // read the xml url
		
		// check it's been read else drop an error message
		if($rss)
		{
			$feed_title = $rss->channel->title;
			$feed_description = $rss->channel->description;
			$feed_image = $rss->channel->image->url;
			
			$header = "<div class='row border-bottom mb-2'>
							<div class='d-flex col-1 align-items-center justify-content-center'>
								<img src='$feed_image' alt='' class='img-fluid center-block bg-light rounded' />
							</div>
							<div class='col'>
								<div class='row'>
									<h2 class='fw-bold'>$feed_title</h2>
								</div>
								<div class='row'>
									<h4 class='fst-italic'>$feed_description</h4>
								</div>
							</div>
						</div>";
				
			$items = false;
			foreach($rss->channel->item as $article)
			{
				$items = $items . "<div class='row border-bottom mb-2'>
										<h4 class='fw-bold text-dark'>$article->title</h4>
										<h6 class='pb-2 fst-italic text-secondary'>$article->description</h6>
										<p><span class='fw-bold text-secondary'>Published - </span> $article->pubDate
										<br />
										<span class='fw-bold text-secondary'>Link - </span> <a href='$article-link' target='_blank' class='link-primary'>$article->link</a></p>
									</div>";
			}
		}
		else
		{
			$header = "The has been a problem. Please check the URL is valid and try again.";
			$items = false;
			$url = "None";
		}
	}
	else
	{
		$header = false;
		$items = false;
		$url = "None";
	}
	?>
</head>
<body>
	<div class="pt-3 ps-3 pe-3 d-flex flex-column">
		<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
			<div class="input-group mb-3">
				<div class="input-group">
					<button class="btn btn-outline-success" type="submit" >Grab RSS</button>
					<input type="url" class="form-control" placeholder="Enter RSS URL" name="url" required>
				</div>
			</div>
		</form>
	</div>
	<div class="ps-3 pe-3">
	Viewing RSS Feed - <span class="fst-italic"><?php echo($url); ?></span>
	</div>
	<div class="p-3 d-flex flex-column">
		<?php echo($header); ?>
		<?php echo($items); ?>
	</div>
</body>
<!-- Bootstrap for styling -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
</html>