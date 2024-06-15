<?php $this->extend('Inc/Main');?>
<?php $this->section('css');?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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
                            <label for="pickPosition" class="form-label">Position</label>
                            <select id="pickPosition" name="positionID" class="form-select select2">
                                
                            </select>
                        
                        </div>
                        <div class="mb-3">
                            <label for="pickKaryawan" class="form-label">Employee</label>
                            <select id="pickKaryawan" name="employeeID" class="form-select select2">
                                
                            </select>
                        
                        </div>
                        <div class="mb-3">
                        <label class="form-label ">Salary Date</label>
                            <input type="date" class="form-control" name="salary_date" id="salary_date"/>
                            
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="useBonus" value="1" id="useBonus" >
                            <label class="form-check-label" for="flexRadioDefault2">
                                Use Bonus?
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary mb-3">Submit</button>
                    </form>

                    <button  class="btn btn-danger" onClick="hitung()">Hitung Gaji</button>
                </div>
            </div>

        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Salary Details</h6>
                </div>
                <div class="card-body" id="salaryDetails">
                    <!-- Salary details will be appended here -->
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

    function getKaryawan(positionID) {
        $.ajax({
            url: `${domain}/dashboard/employee/dropdown`,
            method: 'POST',
            dataType: 'json',
            data :{
                positionID : positionID
            },
            success: function (response) {
                console.log(response);
                $('#pickKaryawan').empty();
                if (response) {
                    $('#pickKaryawan').append($('<option>', {
                        value: '',
                        text: 'Choose Employee'
                    }));
                    response.forEach(function (employee) {
                        let name = employee.first_name + ' ' + employee.last_name;
                        $('#pickKaryawan').append($('<option>', {
                            value: employee.id,
                            text: name
                        }));
                    });
                } else {
                    $('#pickKaryawan').append($('<option>', {
                        value: '',
                        text: 'No Employees found'
                    }));
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    function getSalary(positionID,employeeID) {
        $.ajax({
            url: `${domain}/dashboard/salary/getTotal`,
            method: 'POST',
            dataType: 'json',
            data :{
                positionID : positionID,
                employeeID : employeeID
            },
            success: function (response) {
                console.log(response);
                appendSalaryDetails(response);
                
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    function hitung(){
        var positionID = $("#pickPosition").val();
        var employeeID = $("#pickKaryawan").val();
       
        if (!positionID) {
            alert("Please select a position.");
            return;
        }

        if (!employeeID) {
            alert("Please select an employee.");
            return;
        }
        console.log("Position ID: " + positionID + ", Employee ID: " + employeeID);
        getSalary(positionID, employeeID);
    }

    function appendSalaryDetails(salary) {
        var bonus =  $("#useBonus").is(':checked');
        console.log(bonus);
        var bonusRate;
        if(!bonus){
            bonusRate = 0;
        }else{
            bonusRate = parseFloat(salary.bonus_rate);
        }
        
        var basicSalary = parseFloat(salary.basic_salary);
        var bonus = (bonusRate / 100) * basicSalary ;
        var tax = basicSalary * 0.05;
        var totalSalary = bonus + basicSalary;
        

        var detailsHTML = `
            <p>Bonus Rate: ${bonusRate}%</p>
            <p>Basic Salary: Rp${basicSalary.toLocaleString()}</p>
            <p>Calculated Bonus: Rp${bonus.toLocaleString()}</p>
            <p>Tax: Rp${tax.toLocaleString()}</p>
            <p>Total Salary: Rp${totalSalary.toLocaleString()}</p>
        `; 
        

        $("#salaryDetails").html(detailsHTML);
    }


$(document).ready(function () {    
    getPosition();
    $("#pickPosition").change(function(){
        let employeeID = $(this).val();
        getKaryawan(employeeID);
    });
    $("#pickPosition").select2({
        placeholder: {
            id: '',
            text: 'Choose Position'
        },
        language: "en",
    });
    $("#pickKaryawan").select2({
        placeholder: {
            id: '',
            text: 'Choose Employee'
        },
        language: "en",
    });
});
</script>
<?php $this->endSection();?>