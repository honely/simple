<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $course['course_name']?></title>
    <link rel="stylesheet" type="text/css" href="/Public/home/css/music.css">
    <link rel="stylesheet" type="text/css" href="/Public/home/css/html5.css"/>
    <script src="/Public/home/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
    <script>
        (function (doc, win) {
            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth)
                        return;
                    docEl.style.fontSize = 25 * (clientWidth / 720) + 'px';
                };
            if (!doc.addEventListener)
                return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
    </script>
</head>
<body>
	<style type="text/css">
		.jAudio--ui{padding-top: 50px;}
		.jAudio--player .jAudio--thumb{margin-top: 0;}
		.jAudio--player .jAudio--status-bar{display: block;}
		.jAudio--player .jAudio--details p span{width: 100%; margin-top: 5px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; font-weight: bold;} 
		.jAudio--player .jAudio--details p span:nth-of-type(2){font-size:1rem; margin-top: 5px;margin-bottom: 3rem;}
	</style>
<div class='jAudio--player'>
    <audio></audio>
    <div class='jAudio--ui'>
        <div class='jAudio--thumb'></div>
        <div class='jAudio--status-bar'>
            <div class='jAudio--details'></div>
            <div class='jAudio--volume-bar'></div>
            <div class='jAudio--progress-bar'>
                <div class='jAudio--progress-bar-wrapper'>
                    <div class='jAudio--progress-bar-played'>
                        <span class='jAudio--progress-bar-pointer'></span>
                    </div>
                </div>
            </div>
            <div class='jAudio--time'>
                <span class='jAudio--time-elapsed'>00:00</span>
                <span class='jAudio--time-total'>00:00</span>
            </div>
        </div>
    </div>
    <div class='jAudio--controls'>
        <ul>
            <li><button class='btn' data-action='prev' id='btn-prev'><span></span></button></li>
            <li><button class='btn' data-action='play' id='btn-play'><span></span></button></li>
            <li><button class='btn' data-action='next' id='btn-next'><span></span></button></li>
        </ul>
    </div>
    <div class="bflb_head">
        <h4>播放列表</h4>
    </div>
    <div class='jAudio--playlist' id="bar">
    </div>
    <?php if(!$user_auth):?>
    <div class="button_box pd_lr06" style="background: #fff;">
        <a class="but mg_b10 mg_t10" href="<?=U('personal/shengjihuiyuan')?>">入学</a>
    </div>
    <?php endif;?>
</div>
</body>
</html>
<script>
    var sh;
    (function($){

        var pluginName = "jAudio",
            defaults = {
                playlist: [],

                defaultAlbum: undefined,
                defaultArtist: undefined,
                defaultTrack: 0,
                autoPlay:true,

                debug: false
            };
        function Plugin( $context, options )
        {
            this.settings         = $.extend( true, defaults, options );

            this.$context         = $context;

            this.domAudio         = this.$context.find("audio")[0];
            this.$domPlaylist     = this.$context.find(".jAudio--playlist");
            this.$domControls     = this.$context.find(".jAudio--controls");
            this.$domVolumeBar    = this.$context.find(".jAudio--volume");
            this.$domDetails      = this.$context.find(".jAudio--details");
            this.$domStatusBar    = this.$context.find(".jAudio--status-bar");
            this.$domProgressBar  = this.$context.find(".jAudio--progress-bar-wrapper");
            this.$domTime         = this.$context.find(".jAudio--time");
            this.$domElapsedTime  = this.$context.find(".jAudio--time-elapsed");
            this.$domTotalTime    = this.$context.find(".jAudio--time-total");
            this.$domThumb        = this.$context.find(".jAudio--thumb");

            this.currentState       = "pause";
            this.currentTrack       = this.settings.defaultTrack;
            this.currentElapsedTime = undefined;

            this.timer              = undefined;

            this.init();
        }

        Plugin.prototype = {

            init: function()
            {
                var self = this;
                self.renderPlaylist();
                self.preLoadTrack();
                self.highlightTrack();
                self.updateTotalTime();
                self.events();
                self.debug();
                self.domAudio.volume = 1;
                self.play()//增加此行自动执行play 2017-9-4 by 1stmoon
            },

            play: function()
            {
                console.log("play");
                sh =setInterval(function(){$.get("<?=U('course/learntime',array('course_id'=>$lesson['course_id'],'lesson_id'=>$lesson['lesson_id']))?>")},5000);
                var self        = this,
                    playButton  = self.$domControls.find("#btn-play");

                self.domAudio.play();

                if(self.currentState === "play") return;

                clearInterval(self.timer);
                self.timer = setInterval( self.run.bind(self), 50 );

                self.currentState = "play";

                // change id
                playButton.data("action", "pause");
                playButton.attr("id", "btn-pause");

                // activate
                playButton.toggleClass('active');
            },

            pause: function()
            {
                console.log("pause")
                var self        = this,
                    playButton  = self.$domControls.find("#btn-pause");

                self.domAudio.pause();
                clearInterval(self.timer);

                self.currentState = "pause";

                // change id
                playButton.data("action", "play");
                playButton.attr("id", "btn-play");

                // activate
                playButton.toggleClass('active');

            },

            stop: function()
            {
                console.log("stop")
                clearInterval(sh);
                var self = this;

                self.domAudio.pause();
                self.domAudio.currentTime = 0;

                self.animateProgressBarPosition();
                clearInterval(self.timer);
                self.updateElapsedTime();

                self.currentState = "stop";
            },

            prev: function()
            {
                console.log("prev")
                clearInterval(sh);
                var self  = this,
                    track;

                (self.currentTrack === 0)
                    ? track = self.settings.playlist.length - 1
                    : track = self.currentTrack - 1;

                self.changeTrack(track);
            },
            next: function()
            {
                console.log("next")
                clearInterval(sh);
                var self = this,
                    track;

                (self.currentTrack === self.settings.playlist.length - 1)
                    ? track = 0
                    : track = self.currentTrack + 1;

                self.changeTrack(track);
            },


            preLoadTrack: function()
            {
                var self      = this,
                    defTrack  = self.settings.defaultTrack;

                self.changeTrack( defTrack );

                self.stop();
            },

            changeTrack: function(index)
            {
                var self = this;

                self.currentTrack  = index;
                self.domAudio.src  = self.settings.playlist[index].file;

                if(self.currentState === "play" || self.settings.autoPlay)
                    self.play();

                self.highlightTrack();

                self.updateThumb();

                self.renderDetails();
            },

            events: function()
            {
                var self = this;
                // - controls events
                self.$domControls.on("click", "button", function()
                {
                    console.log("click1")
                    clearInterval(sh);
                    var action = $(this).data("action");

                    switch( action )
                    {
                        case "prev":
                            var prev_margin = self.currentTrack -1;
                            if(prev_margin < 0){
                                prev_margin= <?= sizeof($lessoninfo);?>-1;
                            }
                            //window.location.href="<?= U('course/popaudio',array('lesson_id'=>$lesson['lesson_id']))?>";
                            self.prev.call(self);
                            break;
                        case "next":
                            var next_margin = self.currentTrack +1;
                            if(next_margin >= <?= sizeof($lessoninfo);?>){
                                next_margin=0;
                            }
                            self.next.call(self);
                            //window.location.href="<?= U('course/popaudio',array('lesson_id'=>$lesson['lesson_id']))?>";
                            break;
                        case "pause": self.pause.call(self); break;
                        case "stop": self.stop.call(self); break;
                        case "play": self.play.call(self); break;
                    };

                });

                // - playlist events
                self.$domPlaylist.on("click", ".jAudio--playlist-item", function(e)
                {
                    console.log("click2")
                    clearInterval(sh);
                    var item = $(this),
                        track = item.data("track"),
                        index = item.index();
                    if(self.currentTrack === index) return;
                    //window.location.href="<?= U('course/popaudio',array('lesson_id'=>$lesson['lesson_id']))?>";
                    self.changeTrack(index);
                });

                // - volume's bar events
                // to do

                // - progress bar events
                self.$domProgressBar.on("click", function(e)
                {
                    self.updateProgressBar(e);
                    self.updateElapsedTime();
                });

                $(self.domAudio).on("loadedmetadata", function()
                {
                    self.animateProgressBarPosition.call(self);
                    self.updateElapsedTime.call(self);
                    self.updateTotalTime.call(self);
                });
            },


            getAudioSeconds: function(string)
            {
                var self    = this,
                    string  = string % 60;
                string  = self.addZero( Math.floor(string), 2 );

                (string < 60) ? string = string : string = "00";

                return string;
            },

            getAudioMinutes: function(string)
            {
                var self    = this,
                    string  = string / 60;
                string  = self.addZero( Math.floor(string), 2 );

                (string < 60) ? string = string : string = "00";

                return string;
            },

            addZero: function(word, howManyZero)
            {
                var word = String(word);

                while(word.length < howManyZero) word = "0" + word;

                return word;
            },

            removeZero: function(word, howManyZero)
            {
                var word  = String(word),
                    i     = 0;

                while(i < howManyZero)
                {
                    if(word[0] === "0") { word = word.substr(1, word.length); } else { break; }

                    i++;
                }

                return word;
            },


            highlightTrack: function()
            {
                var self      = this,
                    tracks    = self.$domPlaylist.children(),
                    className = "active";

                tracks.removeClass(className);
                tracks.eq(self.currentTrack).addClass(className);
            },

            renderDetails: function()
            {
                var self          = this,
                    track         = self.settings.playlist[self.currentTrack],
                    file          = track.file,
                    thumb         = track.thumb,
                    trackName     = track.trackName,
                    trackArtist   = track.trackArtist,
                    trackAlbum    = track.trackAlbum,
                    template      =  "";

                template += "<p>";
                template += "<span>" + trackName + "</span>";
                // template += " - ";
                template += "<span>" + trackArtist + "</span>";
                //template += "<span>" + trackAlbum + "</span>";
                template += "</p>";


                $(".jAudio--details").html(template);

            },

            renderPlaylist: function()
            {
                var self = this,
                    template = "";


                $.each(self.settings.playlist, function(i, a)
                {
                    var file          = a["file"],
                        thumb         = a["thumb"],
                        trackName     = a["trackName"],
                        trackArtist   = a["trackArtist"],
                        trackAlbum    = a["trackAlbum"];
                    trackDuration = a["trackDuration"];
                    template += "<div class='jAudio--playlist-item' data-track='" + file + "'>";

                    //template += "<div class='jAudio--playlist-thumb'><img src='"+ thumb +"'></div>";

                    template += "<div class='jAudio--playlist-meta-text'>";
                    template += "<h4 style='width: 18rem;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;'>" + trackName + "</h4>";
                    //template += "<p>" + trackArtist + "</p>";
                    template += "<span>" + trackDuration + "订阅</span>";

                    template += "</div>";
                    //template += "<div class='jAudio--playlist-track-duration'>" + trackDuration + "</div>";
                    template += "</div>";

                    // });

                });

                self.$domPlaylist.html(template);

            },

            run: function()
            {
                var self = this;

                self.animateProgressBarPosition();
                self.updateElapsedTime();

                if(self.domAudio.ended) self.next();
            },

            animateProgressBarPosition: function()
            {
                var self        = this,
                    percentage  = (self.domAudio.currentTime * 100 / self.domAudio.duration) + "%",
                    styles      = { "width": percentage };

                self.$domProgressBar.children().eq(0).css(styles);
            },

            updateProgressBar: function(e)
            {
                var self = this,
                    mouseX,
                    percentage,
                    newTime;

                if(e.offsetX) mouseX = e.offsetX;
                if(mouseX === undefined && e.layerX) mouseX = e.layerX;

                percentage  = mouseX / self.$domProgressBar.width();
                newTime     = self.domAudio.duration * percentage;

                self.domAudio.currentTime = newTime;
                self.animateProgressBarPosition();
            },

            updateElapsedTime: function()
            {
                var self      = this,
                    time      = self.domAudio.currentTime,
                    minutes   = self.getAudioMinutes(time),
                    seconds   = self.getAudioSeconds(time),

                    audioTime = minutes + ":" + seconds;

                self.$domElapsedTime.text( audioTime );
            },

            updateTotalTime: function()
            {
                var self      = this,
                    time      = self.domAudio.duration,
                    minutes   = self.getAudioMinutes(time),
                    seconds   = self.getAudioSeconds(time),
                    audioTime = minutes + ":" + seconds;

                self.$domTotalTime.text( audioTime );
            },


            updateThumb: function()
            {
                var self = this,
                    thumb = self.settings.playlist[self.currentTrack].thumb,
                    styles = {
                        "background-image": "url(" + thumb + ")"
                    };

                self.$domThumb.css(styles);
            },

            debug: function()
            {
                var self = this;

                if(self.settings.debug) console.log(self.settings);
            }

        }

        $.fn[pluginName] = function( options )
        {
            var instantiate = function()
            {
                return new Plugin( $(this), options );
            }

            $(this).each(instantiate);
        }

    })(jQuery)


</script>
<script>
    var t = {
        <?php foreach($lessoninfo AS $k=>$v):?>
        <?php if($lesson['lesson_id']==$v['lesson_id']){ ?>
        defaultTrack:<?= $k?>,
        <?php }?>
        <?php endforeach;?>
    playlist: [
    <?php foreach($lessoninfo AS $k=>$v):?>
    {
        file: "<?=$v['lesson_audio']?>",
            thumb: "<?=$v['lesson_image']?>",
        trackName: "<?=$v['lesson_name']?>",
        trackArtist: "<?=$v['lesson_remarks']?>",
        trackAlbum: "<?=$v['course_name']?>",
        trackDuration: "<?=$courseBuy[$v['course_id']]?>",
    },
    <?php endforeach;?>
    ],
    autoPlay: true
    }

    $(".jAudio--player").jAudio(t);

    //跳转到视频播放
    function tiaozhuan(){
        location.href="<?php echo U('course/popular',array('course_id'=>$lesson['course_id'],'lesson_id'=>$lesson['lesson_id']));?>";
    }

</script>