  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../../public/plugins/jquery/jquery-3.7.1.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="../../public/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 4 -->
  <script src="../../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="../../public/plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="../../public/plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="../../public/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="../../public/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="../../public/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="../../public/plugins/moment/moment.min.js"></script>
  <script src="../../public/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../../public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="../../public/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../../public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->

  <script src="../../public/dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->

  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="../../public/dist/js/pages/dashboard.js"></script>
  <script src="../../public/lib/dataTables/dataTables.min.js"></script>
  <!-- DataTables  & Plugins -->

  <script src="../../vendor/sweetalert/sweetalert.min.js"></script>

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