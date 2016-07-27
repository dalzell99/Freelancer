<div class="container-fluid  animated fadeInDown wow" style=" background-color:#003a6e;  color:#fff">
    <div class="container  animated fadeInDown wow" style='width: 100%;'>
			<div class="row">
			<div class="col-md-12">
				<div class="ft-part">
				<div class="col-md-7">
					<div class="col-md-3">
						<h3>Quick Links</h3>
						<ul>
							<li> <a href="about-us.php">About Us</a></li>
							<li><a href="legality.php">Legality</a> </li>
							<li> <a href="terms-of-services.php">Terms of Services</a></li>
							<li><a href="privacy-policy.php">Privacy Policy </a></li>
							<li><a href="sitemap.php">Site Map</a></li>
							<li><a href="testimonial.php">Testimonials</a></li>
						</ul>
					</div>
					<div class="col-md-3">
						<h3>Support</h3>
						<ul>
							<li> <a href="faq.php">FAQ</a></li>
							<li><a href="howitworks.php">Get Started</a> </li>
<li><a href="contact-us.php">Contact Us</a></li>

							<li> <a href="payment.php">Payment Policy</a></li>
							
							<li><a href="quizmaster.php">IQzetoMaster</a></li>
<li><a href="quizmaster.php">We are Hiring</a></li>
							
						</ul>
					</div>
					<div class="col-md-3">
						<h3>Follow Us</h3>
						<ul>
<li> <a target = '_blank' href="https://www.facebook.com/IQzeto-1706229703000965">Facebook &nbsp;<img src="images/facebook.png"></a></li>

<li><a target = '_blank' href="https://twitter.com/iqzeto">Twitter &nbsp; <img src="images/twitter.png"></a></li>

<li> <a target = '_blank'  href="https://www.linkedin.com/company/iqzeto">Linkedin &nbsp; <img src="images/linkedin.png"></a></li>
							<li><a href="">Google Plus &nbsp; <img src="images/googleplus.png"></a> </li>
							<li><a href="">Pinterest &nbsp; <img src="images/pinterest.png"></a> </li>
						</ul>
					</div>
					<div class="col-md-3">
						<h3>Office Address</h3>
						<p>
							IQvirus Services Pvt Ltd<br />
							Plot No - 160<br />
							Sector-1, Block-H<br />
							Alkapoor Township<br />
							Hyderabad-500081<br />
							Telangana<br />
						</p>
					</div>
				</div>
				<div class="col-md-5">
					<div class="payment-part">
						<h3>Our Payment Options</h3>
						<img src="images/payment.png" class="img-responsive">

				</div>
			</div>
			<div class="clearfix"></div>
			<hr class="sepa">
			<div class="row" style="margin:0px;">
				<div style="margin-top:10px;padding-bottom:25px;">
					<div align="center" font-size:13px;">Copyright © <?php echo date('Y');?> IQzeto. All Rights Reserved <span class="hidden"><a href="http://www.innasoft.in">Innasoft Technologies  Pvt Ltd.</a></span></div>

				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
    </div>
	<div class="clearfix"></div>
</div>


<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/modernizr.custom.28468.js"></script>
<script type="text/javascript" src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/js/jquery.cslider.js"></script>

<script>
    $("#rfpform").validate();
</script>

<script type="text/javascript">
    jQuery.noConflict()(function ($) {
        var $container = $('#container-folio');

        if ($container.length) {
            $container.waitForImages(function () {

                // initialize isotope
                $container.isotope({
                    itemSelector: '.box',
                    layoutMode: 'fitRows'
                });

                // filter items when filter link is clicked
                $('#filters a').click(function () {
                    var selector = $(this).attr('data-filter');
                    $container.isotope({filter: selector});
                    $(this).removeClass('active').addClass('active').siblings().removeClass('active all');

                    return false;
                });

            }, null, true);
        }
    });

</script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {

        $('#da-slider').cslider({
            autoplay: true,
            bgincrement: 50
        });

    });
</script>

<script type="text/javascript">
    // Can also be used with jQuery(document).ready()
    jQuery(window).load(function () {
        jQuery('.portfolio_rotator').flexslider({
            animation: 'slide',
            animationLoop: false,
            useCSS: false,
            controlNav: false,
            controlsContainer: '.portfolio-controls',
            easing: 'easeInOutSine',
            animationSpeed: '500',
            touch: true,
            minItems: 1,
            maxItems: 30,
            mousewheel: false,
            pauseOnHover: true,
            itemWidth: 270,
            itemMargin: 30,
            move: 1,
        });
    });

</script>
<script type="text/javascript">
    // Can also be used with jQuery(document).ready()
    jQuery(window).load(function () {
        jQuery('.clients_rotator_widget_wrap').flexslider({
            animation: 'slide',
            animationLoop: false,
            useCSS: false,
            controlNav: false,
            controlsContainer: '.flex-controls-cl',
            easing: 'easeInOutSine',
            animationSpeed: '200',
            touch: true,
            minItems: 1,
            maxItems: 30,
            itemWidth: 170,
            itemMargin: 30,
            mousewheel: false,
            pauseOnHover: true,
            move: 5,
        });
    });

</script>
<script>
    $(document).ready(function () {
        // Configure/customize these variables.
        var showChar = 150; // How many characters are shown by default
        var ellipsestext = "...";
        var moretext = "Show more >";
        var lesstext = "Show less";

        $('.more').each(function () {
            var content = $(this).html();

            if (content.length > showChar) {

                var c = content.substr(0, showChar);
                var h = content.substr(showChar, content.length - showChar);

                var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                $(this).html(html);
            }

        });

        $(".morelink").click(function () {
            if ($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    });
</script>


</body>


</html>
