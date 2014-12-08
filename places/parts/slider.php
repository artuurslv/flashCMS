    
        <!-- Jssor Slider Begin -->
    <!-- You can move inline styles to css file or css block. -->
    <div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 1000px; height: 500px; overflow: hidden; ">

        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>

        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1000px; height: 500px; overflow: hidden;">
            <div id="slider1">
            <!-- img u="image" src="<?php echo PATH_SITE;?>/img/landscape/22.jpg" height="500"/--> 
             
            </div>
            <div id="slider2">
                <!-- img u="image" src="<?php echo PATH_SITE;?>/img/landscape/11.jpg" height="500"/--> 
            </div>
             <div id="slider3">
                <!-- img u="image" src="<?php echo PATH_SITE;?>/img/landscape/33.jpg" height="500"/--> 
            </div>
        </div>

        <!-- Bullet Navigator Skin Begin -->
        <style>
            /* jssor slider bullet navigator skin 05 css */
            /*
            .jssorb05 div           (normal)
            .jssorb05 div:hover     (normal mouseover)
            .jssorb05 .av           (active)
            .jssorb05 .av:hover     (active mouseover)
            .jssorb05 .dn           (mousedown)
            */
            .jssorb05 div, .jssorb05 div:hover, .jssorb05 .av {
                background: url(img/b05.png) no-repeat;
                overflow: hidden;
                cursor: pointer;
            }

            .jssorb05 div {
                background-position: -7px -7px;
            }

                .jssorb05 div:hover, .jssorb05 .av:hover {
                    background-position: -37px -7px;
                }

            .jssorb05 .av {
                background-position: -67px -7px;
            }

            .jssorb05 .dn, .jssorb05 .dn:hover {
                background-position: -97px -7px;
            }
		  /* jssor slider arrow navigator skin 07 css */
                    /*
                    .jssora07l              (normal)
                    .jssora07r              (normal)
                    .jssora07l:hover        (normal mouseover)
                    .jssora07r:hover        (normal mouseover)
                    .jssora07ldn            (mousedown)
                    .jssora07rdn            (mousedown)
                    */
                    .jssora07l, .jssora07r, .jssora07ldn, .jssora07rdn
                    {
                        position: absolute;
                        cursor: pointer;
                        display: block;
                        background: url(img/a07.png) no-repeat;
                        overflow: hidden;
                    }
                    .jssora07l
                    {
                        background-position: -5px -35px;
                    }
                    .jssora07r
                    {
                        background-position: -65px -35px;
                    }
                    .jssora07l:hover
                    {
                        background-position: -125px -35px;
                    }
                    .jssora07r:hover
                    {
                        background-position: -185px -35px;
                    }
                    .jssora07ldn
                    {
                        background-position: -245px -35px;
                    }
                    .jssora07rdn
                    {
                        background-position: -305px -35px;
                    }

        </style>
        <!-- bullet navigator container -->
        <div u="navigator" class="jssorb05" style="position: absolute; bottom: 16px; right: 6px; height: 5px !important;">
            <!-- bullet navigator item prototype -->
            <div u="prototype" style="POSITION: absolute; WIDTH: 16px; HEIGHT: 16px;"></div>
        </div>
        <!-- Bullet Navigator Skin End -->
        <!-- Arrow Navigator Skin Begin -->
        <style>
            /* jssor slider arrow navigator skin 12 css */
            /*
            .jssora12l              (normal)
            .jssora12r              (normal)
            .jssora12l:hover        (normal mouseover)
            .jssora12r:hover        (normal mouseover)
            .jssora12ldn            (mousedown)
            .jssora12rdn            (mousedown)
            */
            .jssora12l, .jssora12r, .jssora12ldn, .jssora12rdn {
                position: absolute;
                cursor: pointer;
                display: block;
                background: url(img/a12.png) no-repeat;
                overflow: hidden;
            }

            .jssora12l {
                background-position: -16px -37px;
            }

            .jssora12r {
                background-position: -75px -37px;
            }

            .jssora12l:hover {
                background-position: -136px -37px;
            }

            .jssora12r:hover {
                background-position: -195px -37px;
            }

            .jssora12ldn {
                background-position: -256px -37px;
            }

            .jssora12rdn {
                background-position: -315px -37px;
            }
        </style>
       <!-- Arrow Left -->
                <span u="arrowleft" class="jssora07l" style="width: 50px; height: 50px; top: 180px;
                    left: 3px;"></span>
                <!-- Arrow Right -->
                <span u="arrowright" class="jssora07r" style="width: 50px; height: 50px; top: 180px;
                    right: 3px"></span>
                <!-- Arrow Navigator Skin End -->
    </div>
    <!-- Jssor Slider End -->