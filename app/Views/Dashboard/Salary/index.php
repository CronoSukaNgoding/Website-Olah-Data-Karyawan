<?php $this->extend('Inc/Main');?>
<?php $this->section('css');?>
<?php $this->endSection();?>
<?php $this->section('isKonten');?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?=$title?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Salary Date</th>
                            <th>Basic Salary</th>
                            <th>Bonus</th>
                            <th>Tax</th>
                            <th>Total Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tbody>
                   
                </table>
            </div>
        </div>
    </div>

</div>
<?php $this->endSection();?>
<?php $this->section('javascript');?>
<?php $this->endSection();?>