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
                        <label for="name" class="form-label">Position Name</label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="emailHelp" value="<?=$dataPosition->name?>">
                    </div>
                    <div class="mb-3">
                        <label for="pickGrade" class="form-label">Grade</label>
                        <select id="pickGrade" name="grade" class="form-select select2">
                                <option ></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="2">3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="basic_salary" class="form-label">Basic Salary</label>
                        <input type="text" class="form-control" name="basic_salary" id="basic_salary" aria-describedby="emailHelp" value="<?=$dataPosition->basic_salary?>">
                    </div>
                    <div class="mb-3">
                        <label for="bonus_rate" class="form-label">Bonus Rate</label>
                        <input type="text" class="form-control" name="bonus_rate" id="bonus_rate" aria-describedby="emailHelp" value="<?=$dataPosition->bonus_rate?>">
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
    let selectedGrade = <?=$dataPosition->grade?>;
    let dropdown = document.getElementById('pickGrade');
    dropdown.value = selectedGrade;

    document.addEventListener('DOMContentLoaded', (event) => {
        const basicSalaryInput = document.getElementById('basic_salary');
        const bonusRateInput = document.getElementById('bonus_rate');

        function formatCurrency(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(value);
        }

        function formatPercentage(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'percent',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(value / 100);
        }

        basicSalaryInput.value = parseFloat(basicSalaryInput.value);
        bonusRateInput.value = formatPercentage(parseFloat(bonusRateInput.value));


        bonusRateInput.addEventListener('blur', (event) => {
            event.target.value = formatPercentage(parseFloat(event.target.value.replace(/[^\d.-]/g, '')));
        });
    });

    $(document).ready(function () {    
        $("#pickGrade").select2({
            placeholder: {
                id: '',
                text: 'Choose Grade'
            },
            language: "en",
        });
    });
</script>
<?php $this->endSection();?>