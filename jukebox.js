// test

function jukebox_init(all_videos) {

    var by_id = {};
    for( var k in all_videos ) {
        for( var i = 0; i < all_videos[k].length; i++ ) {
            by_id[all_videos[k][i].pangea_id] = all_videos[k][i];
        }
    }

    $("li.video a").click(function() {
        var video_id = $(this).attr("data-video");
        jukebox_play_video( video_id, by_id[video_id] );
        return(false);
    });

}

function jukebox_play_video(video_id, video_data) {
    $("li.video").removeClass("playing-currently");
    $("li#v" + video_id).addClass("playing-currently");

    $("#playing").animate({ opacity: 0}, 500, function() {

        $("#playing h1").html( video_data.Title );
        $("#playing p").html( video_data.Description );
        $("#playing .video-wrapper").html(
            '<iframe frameborder="0" src="' +
            video_data.embed_url +
            '" width="640" height="380"></iframe>'
        );

        $("#playing").animate({ opacity: 1}, 500);
    });
}
