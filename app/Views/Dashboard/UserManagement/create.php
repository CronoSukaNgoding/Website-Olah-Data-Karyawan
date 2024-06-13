<?php $this->extend('Inc/Main');?>
<?php $this->section('css');?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



<?php $this->endSection();?>
<?php $this->section('isKonten');?>
<div class="container-fluid">
    <div class="row">
        <!-- Content Column -->
        <div class="col-lg-6 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?=$title?></h6>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                    </div>
                   
                    <div class="mb-3">
                        <label for="email" class="form-label">nip</label>
                        <input type="test" class="form-control" name="nip" id="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="test" class="form-control" name="first_name" id="first_name" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="test" class="form-control" name="last_name" id="last_name" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" name="address" id="address" ></textarea>
                    </div>
                    <div class="mb-3" >
                    <label class="form-label">Birth Date</label>
                        <input type="date" class="form-control" name="birth_date" id="birth_date"/>
                        
                    </div>
                    <div class="mb-3" >
                        <label class="form-label">Hire Date</label>
                        <input type="date" class="form-control" name="hire_date" id="hire_date" />
                       
                    </div>
                    <div class="mb-3">
                        <label for="pickPosition" class="form-label">Position</label>
                        <select id="pickPosition" name="positionID" class="form-select select2">
                            
                        </select>
                    
                    </div>
                    <div class="mb-3">
                        <label for="pickRole" class="form-label">Role</label>
                        <select id="pickRole" name="role_id" class="form-select select2">
                            
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pickStatus" class="form-label">Status</label>
                        <select id="pickStatus" name="status" class="form-select select2">
                                <option ></option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $this->endSection();?>
<?php $this->section('javascript');?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    const domain = window.location.host.match(/localhost/g) ? `http://${window.location.host}` : `https://${window.location.host}`;
    function getRole() {
        $.ajax({
            url: `${domain}/dashboard/role/dropdown`,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log(response);
                $('#pickRole').empty();
                if (response) {
                    $('#pickRole').append($('<option>', {
                        value: '',
                        text: 'Choose User'
                    }));
                    response.forEach(function (user) {
                        $('#pickRole').append($('<option>', {
                            value: user.id,
                            text: user.name
                        }));
                    });
                } else {
                    $('#pickRole').append($('<option>', {
                        value: '',
                        text: 'No Users found'
                    }));
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    function getPosition() {
        $.ajax({
            url: `${domain}/dashboard/position/dropdown`,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log(response);
                $('#pickPosition').empty();
                if (response) {
                    $('#pickPosition').append($('<option>', {
                        value: '',
                        text: 'Choose Position'
                    }));
                    response.forEach(function (position) {
                        $('#pickPosition').append($('<option>', {
                            value: position.id,
                            text: position.name
                        }));
                    });
                } else {
                    $('#pickPosition').append($('<option>', {
                        value: '',
                        text: 'No Positions found'
                    }));
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }


$(document).ready(function () {    
    getRole();
    getPosition();
    $("#pickRole").select2({
        placeholder: {
            id: '',
            text: 'Choose Role'
        },
        language: "en",
    });
    $("#pickStatus").select2({
        placeholder: {
            id: '',
            text: 'Choose Status'
        },
        language: "en",
    });
    $("#pickPosition").select2({
        placeholder: {
            id: '',
            text: 'Choose Position'
        },
        language: "en",
    });
});
</script>
<?php $this->endSection();?>