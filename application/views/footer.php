<!-- footer -->
    <footer class="W3Layouts">
        <div class="container-fluid W3Layouts">
            <div class="W3Layouts-footer-grids row">
                <div class="col-md-6 col-lg-6 W3Layouts-footer-grid">
                    <h4>ADDRESS</h4>
                    <ul>
                        <li>6-1-103/103,</li>
                        <li>CRPF lane,Near pulse Hospital,</li>
                        <li>Padmarao Nagar, Secunderabad, Telangana 500025</li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-6 mt-md-0 mt-5 W3Layouts-footer-grid">
                    <h4>GET IN TOUCH</h4>
                    <ul>
                        <li>Tel: <a href="tel:+91 9810150067">+91 9810150067</a></li>
                        <li>Email: <a href="mailto:studentsupport@dbmi.edu.in">studentsupport@dbmi.edu.in </a></li>
                    </ul>
                </div>
            </div>
            <div class="W3Layouts-footer-grids row">
              <div class="col-md-12 col-lg-12 mt-lg-0 mt-5 W3Layouts-footer-grid center"><br><br><br>
                    <!-- <h4 class="W3Layouts">Copy Rights</h4> -->
                    <p class="W3Layouts">&copy; 2021 HYDERABAD BHATIA | All Rights Reserved </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- //footer -->
	
    <!-- move top -->
    <button onclick="topFunction()" id="movetop" title="Go to top">
        <span class="fa fa-angle-up"></span>
    </button>
    <script>
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {scrollFunction()};
        
        function scrollFunction() {
          if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("movetop").style.display = "block";
          } else {
            document.getElementById("movetop").style.display = "none";
          }
        }
        
        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
          document.body.scrollTop = 0;
          document.documentElement.scrollTop = 0;
        }
        </script>
    <!-- /move top -->

	<!-- requires js files -->
    <script src="<?php echo base_url()?>assets/website/js/jquery-3.4.1.min.js"></script>
    <script src="<?php echo base_url()?>assets/website/js/bootstrap.js"></script>
    

</body>

</html>