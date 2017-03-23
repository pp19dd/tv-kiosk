<?php
require("data.php");
$all_videos = get_feed();
?>
<!doctype html>
<html>
<head>
    <title>kiosk demo</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/reset.css" />
    <link rel="stylesheet" type="text/css" href="css/kiosk.css" />
</head>
<body>

    <header id="page-header">
        <div class="inner">
            <h1>VOA Kiosk</h1>
        </div>
    </header>

    <main id="main" class="inner">

        <section id="playing">
            <h2>Currently playing</h2>
        </section>

        <section id="listings">

            <?php foreach( $all_videos as $category => $videos ) { ?>
            <h2 class="category"><?php echo $category ?></h2>

            <ul class="videos">
            <?php foreach( $videos as $video ) { ?>

            <li class="video">
                <a href="<?php echo $video->Link ?>">
                    <h3><?php echo $video->Title ?></h3>
                    <div class="video-still"><img src="<?php echo pangea_image( $video->Image, 300 ); ?>" /></div>
                    <p class="description"><?php echo $video->Description ?></p>
                </a>
            </li>

            <?php } # videos ?>
            </ul>

            <?php } #categories ?>
        
        </section>

    </main>

    <footer>VOA footer...</footer>

</body>
</html>
