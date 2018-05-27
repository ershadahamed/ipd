<div id="main-header">
    <div class="container">
        <div id="main-logo-sm">
            <a href="#"><img src="ui/images/main-logo-sm.png" alt="CIFA"></a>
        </div><!-- #main-logo-sm -->
        <div id="main-topbar">
            <div id="main-menu">
                <ul class="menu-list">
                    <li class="menu-item home">
                        <a href="" class="menu-link"><i class="glyphicon glyphicon-home"></i></a>
                    </li>
                    <li class="menu-item">
                        <a href="" class="menu-link">About CIFA</a>
                    </li>
                    <li class="menu-item">
                        <a href="" class="menu-link">FAQ</a>
                    </li>
                    <li class="menu-item">
                        <a href="" class="menu-link">Media</a>
                    </li>
                    <li class="menu-item">
                        <a href="" class="menu-link">CIFA Workspace</a>
                    </li>
                    <li class="menu-item">
                        <a href="" class="menu-link">Contact Us</a>
                    </li>
                </ul>
                <div class="clearfix"></div><!-- .clearfix -->
            </div><!-- #main-menu -->
            <div class="clearfix"></div><!-- .clearfix -->
        </div><!-- #main-topbar -->
        <div class="header-content">
            <div class="row">
                <div class="col-md-5">
                    <div id="main-breadcrumb">
                        <ul class="list">
                            <li class="item"><a class="link" href="#">Home</a></li>
                            <li class="item divider">//</li>
                            <li class="item"><a class="link" href="#">Category</a></li>
                            <li class="item divider">//</li>
                            <li class="item"><a class="link" href="#">Current Page Title</a></li>
                        </ul>
                        <div class="clearfix"></div><!-- .clearfix -->
                    </div><!-- #main-breadcrumb -->
                    <div id="main-page-title">Sub-Page Title</div>
                </div><!-- .col-md-5 -->
                <div class="col-md-7">
                    <?php if ($page == 'page') { ?>
                        <div id="main-featured-button">
                            <div class="row">
                                <div class="col-md-3 remove-padding">
                                    <a class="button button-1" href="#">
                                        <span class="lbl">CIFA Explained</span>
                                    </a>
                                </div><!-- .col-md-3 -->
                                <div class="col-md-3 remove-padding">
                                    <a class="button button-2" href="#">
                                        <span class="lbl">Enroll</span>
                                    </a>
                                </div><!-- .col-md-3 -->
                                <div class="col-md-3 remove-padding">
                                    <a class="button button-3 active" href="#">
                                        <span class="lbl">Why CIFA</span>
                                    </a>
                                </div><!-- .col-md-3 -->
                                <div class="col-md-3 remove-padding">
                                    <a class="button button-4" href="#">
                                        <span class="lbl">CIFA Institution</span>
                                    </a>
                                </div><!-- .col-md-3 -->
                            </div><!-- .row -->
                        </div><!-- #main-featured-button -->
                    <?php } else { ?>
                        <div id="main-profile-bar">
                            <div class="thumbnail" style="background-image: url('ui/images/sample-profile-pic.png')"></div>
                            <div class="content">
                                <div class="item username">Syaiful Shah Zinan</div>
                                <div class="item user-id margin-sm-bottom"><span class="lbl">ID</span> 007</div>
                                <div class="item menu">
                                    <a class="btn theme-button theme-button-white theme-button-uppercase" href="#">Profile</a>
                                    <a class="btn theme-button theme-button-white theme-button-uppercase" href="#">Logout</a>
                                </div><!-- .item -->
                            </div><!-- .content -->
                            <div class="clearfix"></div><!-- .clearfix -->
                        </div><!-- #main-profile-bar -->
                    <?php } ?>
                    <div class="clearfix"></div><!-- .clearfix -->
                </div><!-- .col-md-8 -->
            </div><!-- .row -->
        </div><!-- .header-content -->
    </div><!-- .container -->
</div><!-- #main-header -->