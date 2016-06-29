@extends('.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        @include('common.success')
        @include('common.failure')
        @include('common.validation')
            <div class="panel panel-default">
                <div class="panel-heading">Statistics of Individual Errors</div>
            </div>
            <!-- show error stats here -->
              <div class="panel-body">
                <div class="col-lg-6">
                   <div class="panel panel-default">
                       <div class="panel-heading">
                           Errors Bar chart:  <b class="voda-text">Success vs Failure</b>
                       </div>
                       <!-- /.panel-heading -->
                       <div class="panel-body">
                           <div class="flot-chart">
                               <div class="flot-chart-content" id="flot-bar-chart"></div>
                           </div>
                       </div>
                       <!-- /.panel-body -->
                   </div>
                   <!-- /.panel -->
               </div>
               <!-- show error stats in pie chart -->
               <div class="col-lg-6">
                       <div class="panel panel-default">
                           <div class="panel-heading">
                               Pie Chart: <b class="voda-text"> Errors Distribution </b>
                           </div>
                           <!-- /.panel-heading -->
                           <div class="panel-body">
                               <div class="flot-chart">
                                   <div class="flot-chart-content" id="flot-pie-chart"></div>
                               </div>
                           </div>
                           <!-- /.panel-body -->
                       </div>
                       <!-- /.panel -->
                   </div>
               <!-- end show error stats in pie chart -->
            </div>
            <!-- End show error stats here -->



        </div>
    </div>
</div>

@endsection
