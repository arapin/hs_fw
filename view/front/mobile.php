    <!-- Owl Carousel Assets -->
    <link href="/css/owl.carousel.css" rel="stylesheet">
    <link href="/css/owl.theme.css" rel="stylesheet">
    <script src="/js/owl.carousel.js"></script>


    <!-- Demo -->

    <style>
    #owl-demo .item{
        margin: 3px;
    }
    #owl-demo .item img{
        display: block;
        width: 100%;
        height: auto;
    }
    </style>


    <script>
    $(document).ready(function() {
      $("#owl-demo").owlCarousel({
        autoPlay: 3000,
        items : 4,
		 autoHeight : true,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3]
      });
	setGoogleMap();

    });
    </script>
