<?php $this->extend('Inc/Main');?>
<?php $this->section('css');?>
<?php $this->endSection();?>
<?php $this->section('isKonten');?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalUsers"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</div>
<?php $this->endSection();?>
<?php $this->section('javascript');?>
<script>
    const domain = window.location.host.match(/localhost/g) ? `http://${window.location.host}` : `https://${window.location.host}`;
    function getCountUser() {
        $.ajax({
            url: `${domain}/dashboard/employee/count`,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#totalUsers').text(response);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }
    $(document).ready(function () {    
        getCountUser();
        
    });
</script>
<?php $this->endSection();?>