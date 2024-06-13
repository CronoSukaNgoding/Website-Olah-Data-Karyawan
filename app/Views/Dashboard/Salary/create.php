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
                    <label class="form-label ">Salary Date</label>
                        <input type="date" class="form-control" name="salary_date" id="salary_date"/>
                        
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="useBonus" value="1" id="flexRadioDefault2" >
                        <label class="form-check-label" for="flexRadioDefault2">
                            Use Bonus?
                        </label>
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
    getPosition();
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