<?php
require("data.php");
$all_videos = get_feed();
?>
<!doctype html>
<html>
<head>
    <title>kiosk demo</title>
    <meta charset="utf-8" />
</head>
<body>
<?php foreach( $all_videos as $category => $videos ) { ?>
    <h1><?php echo $category ?></h1>

    <blockquote>

<?php foreach( $videos as $video ) { ?>

        <div class="video">
            <h2><a href="<?php echo $video->Link ?>"><?php echo $video->Title ?></a></h2>
            <p><?php echo $video->Description ?></p>

            <p><pre><?php print_r( $video ); ?></pre></p>
            <p><img src="<?php echo pangea_image( $video->Image, 200 ); ?>" />"></p>
        </div>

<?php } # videos ?>

    </blockquote>

<?php } #categories ?>
</body>
</html>
