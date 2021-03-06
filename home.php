<?php
require("data.php");
$all_videos = get_feed();
?>
<!doctype html>
<html>
<head>
    <title>kiosk demo</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/reset.css?v=a<?php echo VERSION ?>" />
    <link rel="stylesheet" type="text/css" href="css/kiosk.css?v=a<?php echo VERSION ?>" />
    <script src="jukebox.js?v=a<?php echo VERSION ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,700" />
</head>
<body>

    <header id="page-header">
        <div class="inner">
            <h1><a rel="home" href="http://www.voanews.com/"></a></h1>
        </div>
    </header>



    <main id="main" class="inner">

        <section id="playing">
            <section class="player">

<?php
// grabs a random video to display
$all_cat = array_keys($all_videos);
shuffle($all_cat);
$any_vid = $all_videos[$all_cat[0]][0];
?>

                <div class="video-wrapper"><iframe frameborder="0" src="<?php echo $any_vid->embed_url; ?>" width="640" height="380"></iframe></div>

                <h1><?php echo $any_vid->Title; ?></h1>
                <p><?php echo $any_vid->Description; ?></p>

            </section>
        </section>

        <section id="listings">

            <?php foreach( $all_videos as $category => $videos ) { ?>
            <h2 class="category"><?php echo $category ?></h2>

            <ul class="videos">
            <?php foreach( $videos as $video ) { ?>

            <li class="video" id="v<?php echo $video->pangea_id; ?>">
                <a href="<?php echo $video->Link ?>" data-video="<?php echo $video->pangea_id; ?>">
                    <h3><?php echo $video->Title ?></h3>
                    <div class="video-still"><img src="<?php echo pangea_image( $video->Image, 300 ); ?>" /></div>

                    <p class="description"><?php echo mb_substr( $video->Description, 0, 112 ); ?>...</p>
                </a>
                <time class="published" datetime="<?php echo date( 'Y-m-d\TH:i', strtotime($video->PublicationDate) ); ?>"><?php echo smarty_modifier_ago($video->PublicationDate); ?> ago</time>
            </li>

            <?php } # videos ?>
            </ul>

            <?php } #categories ?>

        </section>

    </main>


<script>
var all_videos = <?php echo json_encode($all_videos); ?>;

jQuery(document).ready(function() {
    jukebox_init(all_videos);
});
</script>

</body>
</html>
