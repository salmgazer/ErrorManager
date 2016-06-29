    <!-- jQuery Version 1.11.0 -->
    <!--<script src="/js/jquery-1.11.0.js"></script>-->
    <script src="/js/jquery-2.1.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>

    <!-- Custom script -->
    <script type="text/javascript" src="/js/custom.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/js/plugins/metisMenu/metisMenu.min.js"></script>

    @if($datatables == 'true')
    <!-- DataTables JavaScript -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#users-Table').dataTable();
    });
    </script>
    @endif

    @if($flot == 'true')
    <!-- Flot Charts JavaScript -->
    <script src="/js/plugins/flot/excanvas.min.js"></script>
    <script src="/js/plugins/flot/jquery.flot.js"></script>
    <script src="/js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script>
      $(function() {

          var barOptions = {
              series: {
                  bars: {
                      show: true,
                      barWidth: 0.3
                  }
              },
              xaxis: {
                  ticks:[[0, 'Success'], [1, 'Failure']]
              },
              grid: {
                  hoverable: true
              },
              legend: {
                  show: false
              },
              tooltip: true,
              tooltipOpts: {
                  content: "Status: %x, Count: %y"
              }
          };
          var barData = {
              color: "#409628",
              label: "bar",
              data: [
                  [0, {{ $errors_success }}],
                  [1, {{ $errors_failure }}]
              ]
          };
          $.plot($("#flot-bar-chart"), [barData], barOptions);
      });
      </script>
      <script>
      //Flot Pie Chart
      $(function() {

          var data = [{
              label: "Null",
              data: {{ $null }}
          }, {
              label: "Billing.CBS.ActivateSubscriber",
              data: {{ $billing }}
          }, {
              label: "Communications.SMTP.SendEmail",
              data: {{ $smtp }}
          }, {
              label: "&nbsp;&nbsp;|",
              data: {{ $vb }}
          }];

          var plotObj = $.plot($("#flot-pie-chart"), data, {
              series: {
                  pie: {
                      show: true
                  }
              },
              grid: {
                  hoverable: true
              },
              tooltip: true,
              tooltipOpts: {
                  content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                  shifts: {
                      x: 20,
                      y: 0
                  },
                  defaultTheme: false
              }
          });

      });
  </script>
    @endif
    <!-- Custom Theme JavaScript -->
    <script src="/js/sb-admin-2.js"></script>
