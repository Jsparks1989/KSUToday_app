<!-- 
    app-base.blade.php is the very root of the view. 

    Only has header, main content area, footer.

    Has @yields  to add:
        1. css-styles
        2. navbar
        3. sidebar
        4. main content
    
 -->






<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>KSU Today</title>
        <!--<link rel="stylesheet" href="../css/flexslider.css">-->
        <!--<link rel="stylesheet" type="text/css" href="default.css">-->
        <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous">
        </script>
        
        
        
        <script>
            $(document).ready(function() {
            //    $('.flexslider').flexslider({
            //        animation: "slide",
            //        pauseOnHover: true,
            //        prevText: "",
            //        nextText: "",
            //        slideshowSpeed: 8000
            //    });
                
                // Sidebar JS
                function toggleSecondaryNav(e,a,s){console.log("toggleSecondaryNav",e);var i=s,r=e,n="fast";i.is(":visible")?(a.removeClass("minus").addClass("open-icon").removeClass("close-icon"),r.removeClass("active_section_transition"),i.slideUp(n)):(a.addClass("minus").addClass("close-icon").removeClass("open-icon"),r.addClass("active_section_transition"),i.slideDown(n))}function closeSecondaryNav(e,a,s){console.log("closeSecondaryNav",a),s="undefined"!=typeof s?s:!1;var i;if(i=s?"#mobile_high_council_chamber":".secondary_nav",!e.hasClass("second_tier")){var r=$(i+" li.active_section_transition, "+i+" li.active_section").not(a),n=r.children("ul"),l=r.children(".plus_wrapper");n.slideUp("fast"),r.removeClass("active_section_transition"),l.removeClass("minus").addClass("open-icon").removeClass("close-icon")}}var mobileQuery="56em",fullMobileQuery="40em";$(".secondary_nav li > a").filter($(".plus_wrapper").prev("a")).click(function(e){e.preventDefault();var a=$(this).parent("li"),s=a.parent("ul"),i=$(this).next(),r=i.next("ul");closeSecondaryNav(s,a),toggleSecondaryNav(a,i,r)}),$(".secondary_nav li > .plus_wrapper").click(function(){var e=$(this).parent("li"),a=e.parent("ul"),s=$(this),i=s.next("ul");closeSecondaryNav(a,e),toggleSecondaryNav(e,s,i)});var active=$(".secondary_nav .active"),activeParent=active.parent("ul");if(activeParent.hasClass("third_tier")){activeParent.show(),activeParent.prev(".plus_wrapper").addClass("minus");var rootWrapper=activeParent.parent("li").parent("ul");rootWrapper.show(),rootWrapper.prev(".plus_wrapper").addClass("minus")}else if(activeParent.hasClass("second_tier"))activeParent.show(),activeParent.prev(".plus_wrapper").addClass("minus");else{var childUl=active.children("ul");childUl.length>0&&(childUl.show(),active.children(".plus_wrapper").addClass("minus"))}
            });
        </script>
        
        
        <!-- 
            <style>
                /* Default Styles */
                @charset  "UTF-8";@-moz-document url-prefix(){}a{color:#007a95;text-decoration:none}a:hover{color:#febc11}a.black{color:#000}a.black:hover{color:#007a95}.clear{clear:both}html{font-size:.85em;-webkit-font-smoothing:subpixel-antialiased;background:#000}body{margin:0;padding:0;font-family:Arial,Helvetica,sans-serif;font-size:19.2px;font-size:1.2rem}h1,h2,h3,h4,h5,h6{font-family:'Roboto Condensed',sans-serif}h1{font-size:41.6px;font-size:2.6rem}h2{font-size:33.6px;font-size:2.1rem}h3{font-size:28.8px;font-size:1.8rem}h4{font-size:24px;font-size:1.5rem}h5{font-size:16px;font-size:1rem}h6{font-size:13.28px;font-size:.83rem}hr{outline:none;border:none;height:1px;display:block;background:#888;width:100%;clear:both}.site_wrapper{min-width:1200px}.no_script{background:#ee0707;position:fixed;z-index:10;width:95.5%;font-size:1rem;text-align:center;padding:5px 0;padding:.3125rem 0;padding-right:2.5%;padding-left:2.5%}.no_script .oops{font-size:1.2rem;position:relative}.site_title{color:#fff;font-family:palatino;width:80%;margin:0 auto;text-align:center;margin-top:11px;margin-top:.6875rem}.site_title a{color:#fff}#header{background:#000;width:100%;height:90px;height:5.625rem;position:relative}#header .logo_container{width:300px;width:18.75rem;position:absolute;z-index:1;left:-10px}#header .logo_container .logo{background:url(logo.png) no-repeat;-webkit-background-size:100%;background-size:100%;background-position:top center;margin:0 auto;width:82%;padding-bottom:21%}#header .logo_container .top{background:url(header-banner-bg.png) repeat-y;-webkit-background-size:100% 1px;background-size:100% 1px;padding-top:47px;padding-top:2.9375rem;padding-bottom:32px;padding-bottom:2rem}#header .logo_container .top a{width:90%;display:block;margin:0 auto}#header .logo_container .bottom{background:url(header-banner-bottom.png) no-repeat;-webkit-background-size:100%;background-size:100%;padding-bottom:20%;width:100%}#header .logo_container.small .top{padding-top:26px;padding-top:1.625rem;padding-bottom:16px;padding-bottom:1rem}#header .logo_container.small .site_title{font-size:19.2px;font-size:1.2rem}#header .logo_container.medium .top{padding-top:21px;padding-top:1.3125rem;padding-bottom:12px;padding-bottom:.75rem}#header .logo_container.medium .site_title{font-size:17.6px;font-size:1.1rem;line-height:22.4px;line-height:1.4rem}#header .logo_container.large .top{padding-top:9px;padding-top:.5625rem;padding-bottom:9px;padding-bottom:.5625rem}#header .logo_container.large .site_title{font-size:16px;font-size:1rem;line-height:22.4px;line-height:1.4rem}#header .logo_container.xlarge .top{padding-top:9px;padding-top:.5625rem;padding-bottom:9px;padding-bottom:.5625rem}#header .logo_container.xlarge .site_title{font-size:14.4px;font-size:.9rem}@-moz-document url-prefix(){#header .logo_container .logo{width:81%;background-size:100%}}.search{float:right;margin-top:30px;margin-top:1.875rem}.search label{display:none}.search input[type="text"],.search input[type="submit"]{outline:none;border:none;margin:0;padding:5px;padding:.3125rem;float:left;-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;height:16px;height:1rem;min-height:0;width:auto}.search input[type="submit"]{background:#febc11;cursor:pointer;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box;font-size:11.2px;font-size:.7rem;-webkit-appearance:none;-moz-appearance:none;border-radius:0}.search input[type="submit"]:hover{background:#feca44}#gold_bar{background:#febc11;width:100%;min-height:40px;min-height:2.5rem;line-height:40px;line-height:2.5rem}#banner{width:100%;position:relative}#banner img{width:100%}#banner .banner_text{background:rgba(0,0,0,0.8);position:absolute;padding:18px;padding:1.125rem;padding-bottom:32px;padding-bottom:2rem;right:10%;bottom:8%;max-width:70%}#banner .banner_text h1{color:#fff;margin:0;font-size:22px;font-size:1.375rem;margin-top:2px;margin-top:.125rem}#banner .banner_text h2{color:#febc11;margin:0;font-size:15px;font-size:.9375rem;font-family:Arial,Helvetica,sans-serif;font-weight:300}#banner .banner_text.left{left:10%;right:auto}#banner .banner_text.top{top:8%;bottom:auto}#banner .banner_text:hover{background:#febc11}#banner .banner_text:hover h1,#banner .banner_text:hover h2{color:#000}#banner .page_title{position:absolute;padding-left:5%;margin:0;bottom:0;z-index:1;color:#fff;font-size:80px;font-size:5rem;width:95%;background:rgba(0,0,0,0.5)}#banner.no_img{background:#e5e5e5}#banner.no_img h1{margin:0;padding-top:30px;padding-top:1.875rem;background:none;color:#000;position:relative;font-size:40px;font-size:2.5rem}#banner.no_img>img{display:none}#banner .bread_crumb{list-style:none;margin:0;padding:0;font-size:16px;font-size:1rem;padding-bottom:10px;padding-bottom:.625rem;padding-top:64px;padding-top:4rem}#banner .bread_crumb::after{content:"";display:block;clear:both}#banner .bread_crumb li{float:left;margin-right:1%;color:#000}#banner .bread_crumb li.active a{color:#000}#banner .bread_crumb li a{color:#007a95}.page_wrapper{padding-bottom:48px;padding-bottom:3rem;padding-top:30px;padding-top:1.875rem;background:#fff}.page>.content{width:60%;float:left;margin-bottom:48px;margin-bottom:3rem}.page>.content h1:first-child{margin-top:0}.page .sidebar{width:35%}.page .sidebar.left{float:left;margin-right:5%;width:28%;position:relative}.page .sidebar.right{float:right}.page .sidebar.left+.content{width:67%}#footer{width:100%;padding:30px 0;padding:1.875rem 0;background:#000;color:#e5e5e5;font-size:16px;font-size:1rem}#footer h1{font-size:20.8px;font-size:1.3rem}#footer h2{font-size:19.2px;font-size:1.2rem}#footer a{color:#e5e5e5}#footer a:hover{color:#febc11}#footer .meta_separator{margin-top:50px;margin-top:3.125rem;background:#febc11;height:2px;display:inline-block}.copyright{text-align:center}.contact_info::after{content:"";display:block;clear:both}.contact_info h1{margin-bottom:0;font-size:24px;font-size:1.5rem;text-transform:uppercase;color:#febc11;display:block;width:100%}.contact_info h2{font-size:20.8px;font-size:1.3rem}.contact_info .kennesaw_campus,.contact_info .marietta_campus{float:left}.contact_info .kennesaw_campus{padding-right:5%}#header_nav{float:right;border-right:1px solid #fff;margin-right:20px;margin-right:1.25rem;padding:5px 0;padding:.3125rem 0;padding-right:20px;padding-right:1.25rem;margin-top:15px;margin-top:.9375rem}#header_nav ul{list-style:none;margin:0;padding:0;float:right}#header_nav ul li{float:left}#header_nav .utility{color:#888;font-size:13.6px;font-size:.85rem}#header_nav .utility li{padding-left:15px;padding-left:.9375rem}#header_nav .utility li a{color:#e5e5e5}#header_nav .utility li a:hover{color:#007a95}#header_nav .active{color:#febc11;clear:both;font-size:17.6px;font-size:1.1rem;margin-top:5px;margin-top:.3125rem}#header_nav .active li{padding-left:15px;padding-left:.9375rem}#header_nav .active li a{color:#febc11}#header_nav .active li a:hover{color:#007a95}#high_council_chamber{list-style:none;margin:0;padding:0;margin-left:10%;padding-left:300px;padding-left:18.75rem;padding-right:5%;font-size:18.72px;font-size:1.17rem;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}#high_council_chamber li{float:left}#high_council_chamber li:nth-child(7){margin-right:0}#high_council_chamber li:hover{background:#feca44}#high_council_chamber a{color:#000;width:72%;padding:0 12.8px;padding:0 .8rem;display:block;white-space:nowrap}#high_council_chamber .mobile{display:none}.outer_rim{width:100%;padding:30px 0;padding:1.875rem 0;margin:30px 0;margin:1.875rem 0;background:#e5e5e5;clear:both}.outer_rim .btn{background:#febc11;border:none}.outer_rim .btn:hover{background:#feca44}.inner_rim{width:80%;margin:0 auto;clear:both;position:relative}.outer_rim:after,.inner_rim:after,.core_worlds:after,.news:after,.events:after,.az_list:after{content:"";display:block;clear:both}.flexslider{border:none;box-shadow:none;-webkit-box-shadow:none;overflow:hidden;margin:0;clear:both;border-radius:0;-webkit-border-radius:0;-moz-border-radius:0;z-index:0}.flexslider .slides>li{position:relative}.flexslider .flex-control-paging{bottom:2%;right:50%;margin-right:-50px;position:absolute;width:auto;opacity:.7}.flexslider .flex-control-paging li{overflow:hidden}.flexslider .flex-control-paging li a{background:#e5e5e5;border:1px solid #777;-webkit-box-shadow:none;box-shadow:none}.flexslider .flex-control-paging li a.flex-active{background:#febc11}.stripListStyles{list-style:none;margin:0;padding:0}.selfClear{content:"";display:block;clear:both}.stripInputAppearanceStyles{-webkit-appearance:none;-moz-appearance:none}.secondary_nav{margin-bottom:48px;margin-bottom:3rem}.secondary_nav ul{list-style:none;margin:0;padding:0}.secondary_nav ul li{border-bottom:1px solid #e5e5e5}.secondary_nav ul li::after{content:"";display:block;clear:both}.secondary_nav ul li a{padding:12.8px 3%;padding:.8rem 3%;width:84.5%;display:block;float:left}.secondary_nav ul li .plus_wrapper{width:.7em;height:.7em;position:relative;cursor:pointer}.secondary_nav ul li .plus_wrapper span{background:#007a95;display:block;position:absolute;border-radius:16px;border-radius:1rem;-webkit-border-radius:1rem;-moz-border-radius:1rem}.secondary_nav ul li .plus_wrapper .vertical{width:.125em;height:.7em;left:50%;margin-left:-0.0625em;-ms-transition:transform .4s;-webkit-transition-property:-webkit-transform;-webkit-transition-duration:.4s;-webkit-transition:-webkit-transform .4s;transition:transform .4s}.secondary_nav ul li .plus_wrapper .horizontal{width:.7em;height:.125em;top:50%;margin-top:-0.0625em}.secondary_nav ul li .plus_wrapper.minus .vertical{-ms-transform:rotate(90deg);-webkit-transform:rotate(90deg);transform:rotate(90deg)}.secondary_nav ul li .plus_wrapper{padding:18.4px 2.5%;padding:1.15rem 2.5%;float:right}.secondary_nav>ul>li{-ms-transition:background-color .4s;-webkit-transition-property:background-color;-webkit-transition-duration:.4s;-webkit-transition:background-color .4s;transition:background-color .4s}.secondary_nav>ul>li.active{background:#4d4d4d}.secondary_nav>ul>li.active>a{color:#fff}.secondary_nav>ul>li.active_section{background:#4d4d4d}.secondary_nav>ul>li.active_section>a{color:#fff}.secondary_nav>ul>li.active_section_transition{background:#4d4d4d}.secondary_nav>ul>li.active_section_transition>a{color:#fff}
                    
                    /* Second/Third Tier Nav */
                    .secondary_nav ul .second_tier{clear:both;display:none}.secondary_nav ul .second_tier li a{padding-left:8%;width:70%}.secondary_nav ul .third_tier{clear:both;display:none}.secondary_nav ul .third_tier li a{padding-left:12%;width:76%}.secondary_nav .second_tier>li{-ms-transition:background-color .4s;-webkit-transition-property:background-color;-webkit-transition-duration:.4s;-webkit-transition:background-color .4s;transition:background-color .4s;background:#f2f2f2}.secondary_nav .second_tier>li.active{background:#e5e5e5}.secondary_nav .second_tier>li.active>a{color:#000}.secondary_nav .second_tier>li.active_section{background:#888}.secondary_nav .second_tier>li.active_section>a{color:#fff}.secondary_nav .second_tier>li.active_section_transition{background:#888}.secondary_nav .second_tier>li.active_section_transition>a{color:#fff}.secondary_nav .third_tier>li{background:#e5e5e5;border-color:#ccc}.secondary_nav .third_tier>li.active>a{color:#000}
            </style>
        -->
        <!-- Linked to the css files instead -->
        <link href="<?php echo e(asset('css/ksu_css/flexslider.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('css/ksu_css/default.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('css/ksu_css/default.less')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('css/ksu_css/ksu.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('css/success.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('css/errors.css')); ?>" rel="stylesheet">
        
        <?php echo $__env->yieldContent('css-styles'); ?>
    </head>

    <body>
        
        <noscript>
            &lt;div class="no_script"&gt;&lt;span class="oops"&gt;Oops!&lt;/span&gt;  &lt;span class="text"&gt;You don't have Javascript enabled.  Some features on this site might not work correctly.&lt;/span&gt;&lt;/div&gt;
        </noscript>    
        
        
        <div class="site_wrapper">
            <div id="header">
                <div class="inner_rim">
                    <!-- CHANGE "SMALL" TO SMALL, MEDIUM, LARGE, XLARGE TO SIZE BANNER -->
                    <div class="logo_container small">
                        <div class="top">
                            <a href="../"><div class="logo" alt="Kennesaw State University"></div></a>
                            <!-- CHANGE PAGE TITLE HERE-->
                            <p class="site_title"><a href="./">KSU TODAY</a></p>
                        </div>
                        <div class="bottom"></div>
                    </div>

                    <form id="search_field" class="search" method="GET" action="http://gsearch.kennesaw.edu/search">
                        <label for="ksusearchbox">Search KSU</label>
                        <input type="text" name="q" id="ksusearchbox" placeholder="KSU Search">
                        <input type="submit" value="SEARCH" name="B1">
                        <input type="hidden" name="site" value="default_collection">
                        <input type="hidden" name="client" value="default_frontend">
                        <input type="hidden" name="output" value="xml_no_dtd">
                        <input type="hidden" name="proxystylesheet" value="default_frontend">

                        <div class="clear"></div>
                    </form>

                    <div id="header_nav">
                        <ul class="utility">
                            <li id="myksu"><a href="../myksu/">MyKSU</a></li>
                            <li><a href="../azindex/">A-Z Index</a></li>
                            <li><a href="../directories.php">Directories</a></li>
                            <li><a href="../maps/">Campus Maps</a></li>
                        </ul>
                        <ul class="active">
                            <li class="featured mobile"><a href="../apply.php">Apply</a></li>
                            <li class="featured mobile"><a href="../visit.php">Visit</a></li>
                            <li class="featured mobile"><a href="../give.php">Give</a></li>
                        </ul>
                    </div><!-- /header utility nav-->
                </div><!-- /inner_rim -->
            </div><!-- /header -->


            <div id="gold_bar">
                <ul id="high_council_chamber">
                    <!-- <li id="first_nav_point"><a href="http://www.kennesaw.edu/about.php">About KSU</a></li>
                    <li><a href="http://www.kennesaw.edu/academics.php">Academics</a></li>
                    <li><a href="http://www.kennesaw.edu/admissions.php">Admissions</a></li>
                    <li><a href="http://www.kennesaw.edu/athletics.php">Athletics</a></li>
                    <li><a href="http://www.kennesaw.edu/campuslife.php">Campus Life</a></li>
                    <li><a href="http://www.kennesaw.edu/research.php">Research</a></li>
                    <li><a href="http://www.kennesaw.edu/global.php">Global</a></li> -->
                    <!-- ====================================================================== -->
                    <!-- navbar location                                                        -->
                    <!-- ====================================================================== -->
                    <?php echo $__env->yieldContent('navbar'); ?>

                </ul>
            </div><!-- /goldbar -->


                

                

            <!-- <div id="banner" class="no_img">
                <div class="inner_rim">
                    <ul class="bread_crumb">
                        <li><a href="./">Site Title</a></li>
                        <li>/</li>
                        <li><a href="">Page Title</a></li>
                    </ul>
                </div> -->
            <!-- </div> --><!-- /banner -->

            <!-- Commented out the banner and replaced with white div -->
            <div style="height: 78.9px; background: white;"></div>

            <div class="page_wrapper">
                <!-- MAIN CONTENT AREA -->
                <!-- ****************************************
                    DO NOT DELETE ANYTHING ABOVE THIS LINE!
                ********************************************* -->
                    



                <div class="inner_rim page">     
                    <?php echo $__env->yieldContent('sidebar'); ?>       
                    <div class="content">
                        <!-- ====================================================================== -->
                        <!-- main content location                                                  -->
                        <!-- ====================================================================== -->

                        <?php echo $__env->yieldContent('main'); ?>

                    </div><!-- /content -->
                </div><!-- /page -->

                
            
                        
                        
                <!-- ****************************************
                    DO NOT DELETE ANYTHING BELOW THIS LINE!
                ********************************************* -->
            </div><!-- /page_wrapper-->


            <div id="footer">
                <div class="inner_rim">
                    <div class="footer_columns">
                        <div class="contact_info" id="contact_info">
                            <h1>University Contact Info</h1>
                            <div class="kennesaw_campus">
                                <h2>Kennesaw Campus</h2>
                                <p>1000 Chastain Road<br>
                                    Kennesaw, GA 30144<br>
                                    Phone: 470-578-6000</p>
                            </div>

                            <div class="marietta_campus">
                                <h2>Marietta Campus</h2>
                                <p>1100 South Marietta Pkwy<br>
                                    Marietta, GA 30060<br>
                                    Phone: 678-915-7778</p>
                            </div>
                        </div>
                    </div><!-- /footer_columns -->

                    <hr class="meta_separator">
                        
                    <div class="copyright"><p>© <span id="copyright-full-year"></span> Kennesaw State University. All Rights Reserved.</p></div>
                    <script>
                        var d = new Date();
                        document.getElementById("copyright-full-year").innerHTML = d.getFullYear();
                    </script>
                </div>

            </div><!-- /footer -->
        </div><!-- /sitewrapper -->
    </body>
</html><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\resources\views/components/app-base.blade.php ENDPATH**/ ?>