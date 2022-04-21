<?php session_start(); ?>
<?php require_once "core/functions.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo $url; ?>/asset/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>/asset/featherIcons/feather.css">
    <link rel="stylesheet" href="<?php echo $url; ?>/asset/data_table/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>/asset/css/style.css">

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
            <div class="card shadow ms-4 mt-5">
                    <div class="card-body">
                        <!-- heading -->
                        <nav class="navbar navbar-light bg-light mb-5">
                            <div class="container-fluid d-flex justify-content-between align-items-center p-0">
                                <!-- contact App -->
                                <div class="d-flex justify-content-center align-items-center">
                                    <img src="<?php echo $url; ?>/asset/img/default1.png" class="rounded-start contactImg"
                                        alt="">
                                    <h3 class="mb-0 text-black-50">Contact App</h3>
                                </div>
                                <div class="">
                                    <!-- create contact tag -->
                                    <a type="button"
                                        class="menu-item-link btn btn-outline-primary py-2 d-flex align-items-center createTag"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="feather-plus-circle fs-4 me-3"></i>
                                        <h6 class="mb-0">Create Contact</h6>
                                    </a>
                                </div>
                            </div>
                        </nav>
                        
                        <!-- modal box start -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <nav class="navbar navbar-light bg-light">
                                            <div class="container-fluid d-flex justify-content-between align-items-center">
                                                <h4 class="mb-0 text-primary"><i class="feather-plus-circle me-2"></i>
                                                    Create New Contact</h4>
                                            </div>
                                        </nav>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                            if(isset($_POST["saveBtn"])){
                                                createNew();
                                            }
                                        ?>
                                        <!-- register form -->
                                        <form method="post" enctype='multipart/form-data' id="regInfo">
                                            <!-- name -->
                                            <div class="nameInput">
                                                <label for="name" class="text-primary text-capitalize fw-bold my-2">name</label>
                                                <input value="<?php echo getOldData("name"); ?>" type="text" name="name"
                                                    class="form-control" id="name">
                                                <small class="text-danger"><?php echo getError("name"); ?></small>
                                            </div>

                                            <!-- phone number -->
                                            <div class="phoneInput mt-2">
                                                <label for="phone" class="text-primary text-capitalize fw-bold my-2">phone
                                                    number</label>
                                                <input value="<?php echo getOldData("phone"); ?>" type="text" name="phone"
                                                    class="form-control" id="phone">
                                                <small class="text-danger"><?php echo getError("phone"); ?></small>
                                            </div>
                                            <!-- Email -->
                                            <div class="emailInput mt-2">
                                                <label for="email" class="text-primary text-capitalize fw-bold my-2">email
                                                    address</label>
                                                <input value="<?php echo getOldData("email"); ?>" type="text" name="email"
                                                    class="form-control" id="email">
                                                <small class="text-danger"><?php echo getError("email"); ?></small>
                                            </div>
                                            <!-- Photo -->
                                            <div class="photoInput mt-2">
                                                <label for="photo" class="text-primary text-capitalize fw-bold my-2">photo
                                                    upload</label>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-inline me-3">
                                                        <input value="<?php ?>" type='file' name="upload" id="photo"
                                                            accept="image/png,image/jpeg" class="d-none" />
                                                        <span class="btn btn-outline-primary text-nowrap" id='button'>Choose
                                                            File</span>
                                                    </div>
                                                    <div class="d-inline text-break" style="width: 350px;" id='val'>
                                                        <?php echo $result = count($_FILES) == 0 ? "No File Chosen": fileChosen();?>
                                                    </div>
                                                </div>
                                                <small class="text-danger"><?php echo getError("upload"); ?></small>
                                            </div>


                                            <div class="phoneInput text-end mt-3">
                                                <button name="saveBtn" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal box end -->

                        <!-- contacts table start -->
                        <div class="hero-callout">
                            <div id="example_wrapper">
                                <table id="example"
                                    class="display nowrap dataTable dtr-inline collapsed border-bottom pt-5 mb-3"
                                    style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom d-none">id</th>
                                            <th class="border-bottom">Name</th>
                                            <th class="border-bottom">Email</th>
                                            <th class="border-bottom">Controls</th>
                                            <th class="border-bottom">Phone Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!getContacts()[1] == 0){
                                            foreach(getContacts()[0] as $contact){ ?>
                                        <tr>
                                            <td class="border-0 d-none"><?php echo $contact["id"]; ?></td>
                                            <td class="d-flex align-items-center border-0">
                                                <div class="contactImg rounded-circle"
                                                    style="background-image: url(store/<?php echo $contact['photo'] ?>);"></div>
                                                <div class="text-capitalize"><?php echo $contact["name"]; ?></div>
                                            </td>
                                            <td class="border-0"><?php echo $contact["email"]; ?></td>
                                            <td>
                                                <a class="btn btn-outline-danger" href=""><i class="feather-trash-2"></i></a>
                                                <a class="btn btn-outline-info" href=""><i class="feather-edit"></i></a>
                                            </td>
                                            <td class="border-0"><?php echo $contact["phone"]; ?></td>
                                        </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- contacts table end -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php clearError(); ?>
<script src="<?php echo $url; ?>/asset/jquery-3.6.0.min.js"></script>
<script src="<?php echo $url; ?>/asset/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $url; ?>/asset/data_table/jquery.dataTables.min.js"></script>
<script src="<?php echo $url; ?>/asset/js/script.js"></script>

</body>

</html>
