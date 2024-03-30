<!--===============================================================================================-->

<script src="../../public/plugins/jquery/jquery-3.7.1.min.js"></script>
<!-- <script src="../../vendor/jquery/jquery-3.2.1.min.js"></script> -->
<script src="../../vendor/isotope/isotope.pkgd.min.js"></script>

<!--===============================================================================================-->
<script src="../../vendor/animsition/js/animsition.min.js"></script> <!-- js que controla el loader -->
<!--===============================================================================================-->
<script src="../../vendor/bootstrap/js/popper.js"></script>
<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<!--===============================================================================================-->
<script src="../../vendor/daterangepicker/moment.min.js"></script>
<script src="../../vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="../../vendor/slick/slick.min.js"></script>
<!--===============================================================================================-->
<script src="../../vendor/parallax100/parallax100.js"></script>
<script src="../../vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
<script src="../../vendor/sweetalert/sweetalert.min.js"></script>
<script src="../../vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../../public/js/slick-custom.js"></script>
<script src="../../public/js/main.js"></script>


<!-- BROWSER SYNC -->
<script id="__bs_script__">
  //<![CDATA[
  try {
    (function() {
      try {
        var script = document.createElement('script');
        if ('async') {
          script.async = true;
        }
        script.src = 'http://HOST:3000/browser-sync/browser-sync-client.js?v=3.0.2'.replace("HOST", location.hostname);
        if (document.body) {
          document.body.appendChild(script);
        } else if (document.head) {
          document.head.appendChild(script);
        }
      } catch (e) {
        console.error("Browsersync: could not append script tag", e);
      }
    })()
  } catch (error) {}
</script>