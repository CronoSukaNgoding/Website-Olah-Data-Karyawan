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
                    <form action="" id="form" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?=$dataUser->userName?>" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?=$dataUser->username?>" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?=$dataUser->email?>" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">nip</label>
                        <input type="test" class="form-control" name="nip" id="email" value="<?=$dataUser->nip?>" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="test" class="form-control" name="first_name" id="first_name" value="<?=$dataUser->first_name?>" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="test" class="form-control" name="last_name" id="last_name" value="<?=$dataUser->last_name?>" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" name="address" id="address" ><?=$dataUser->address?> </textarea>
                    </div>
                    <div class="mb-3" >
                    <label class="form-label">Birth Date</label>
                        <input type="date" class="form-control" name="birth_date" id="birth_date" value="<?=$dataUser->birth_date?>"/>
                        
                    </div>
                    <div class="mb-3" >
                        <label class="form-label">Hire Date</label>
                        <input type="date" class="form-control" name="hire_date" id="hire_date" value="<?=$dataUser->hire_date?>" disabled/>
                       
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
<script>
    const domain = window.location.host.match(/localhost/g) ? `http://${window.location.host}` : `https://${window.location.host}`;
    function validateDates() {
        var birthDate = new Date(document.getElementById('birth_date').value);
        var hireDate = new Date(document.getElementById('hire_date').value);

        if (birthDate > hireDate) {
            alert('Tanggal lahir tidak boleh lebih besar dari tanggal perekrutan.');
            return false;
        }

        return true;
    }

    document.getElementById('form').addEventListener('submit', function(event) {
        if (!validateDates()) {
            event.preventDefault();
        }
    });
</script>
<?php $this->endSection();?>