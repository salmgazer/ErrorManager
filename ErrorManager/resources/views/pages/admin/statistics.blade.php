@extends('.layouts.app')
@section('content')
<div class="container">
    <div class="row">
    <!-- Search Form comes here -->
        

        <div class="col-md-12">
        @include('common.success')
        @include('common.failure')
        <!-- Error categories -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Error Categories for the past <strong class="voda-text">24 </strong> hours
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Error Category</th>
                                <th>Count(24 hours)</th>
                                <th>Success</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Some error name</td>
                                <td>24</td>
                                <td>67%</td>
                                <td><a href="/errors/details/" class="">View Details</a></td>
                            </tr>
                            <tr>
                                <td>Some error name</td>
                                <td>24</td>
                                <td>67%</td>
                                <td><a href="/errors/details/" class="">View Details</a></td>
                            </tr>
                            <tr>
                                <td>Some error name</td>
                                <td>24</td>
                                <td>67%</td>
                                <td><a href="/errors/details/" class="">View Details</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
            </div>
            <!-- End error categories -->

            <!-- individual errors -->
            <div class="panel panel-default">
            <div class="panel-heading">
                Most <i class="voda-text">recent </i> errors
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Error ID</th>
                                <th>Status</th>
                                <th>Reported by</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Some error name</td>
                                <td>Resolved</td>
                                <td><a href="#">Salifu</a></td>
                                <td><a href="/errors/details/" class="">View Details</a></td>
                            </tr>
                            <tr>
                                <td>Some error name</td>
                                <td>Unesolved</td>
                                <td><a href="#">Salifu</a></td>
                                <td><a href="/errors/details/" class="">View Details</a></td>
                            </tr>
                            <tr>
                                <td>Some error name</td>
                                <td>Resolved</td>
                                <td><a href="#">Salifu</a></td>
                                <td><a href="/errors/details/" class="">View Details</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
            </div>
            <!-- end individual errors -->

        </div>
    </div>
</div>
@endsection