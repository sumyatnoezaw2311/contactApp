<?php require_once "core/base.php";

// function for error management
function setError($inputName,$errorMessage){
    $_SESSION["error"][$inputName] = "$errorMessage";
}
function clearError(){
    $_SESSION["error"] = [];
}
function getError($inputName){
    if(isset($_SESSION["error"][$inputName])){
        return $_SESSION["error"][$inputName];
    }else{
        return "";
    }
}

//common functions
function fileChosen(){
    if($_FILES["upload"]["name"]){
        return $_FILES["upload"]["name"];
        // return substr( $_FILES["upload"]["name"],0,15)."...";
    }else{
        return "No file chosen";
    }
}

function getOldData($inputName){
    if(isset($_POST[$inputName])){
        return $_POST[$inputName];
    }else if(isset($_FILES[$inputName]["name"])){
        return $_FILES[$inputName]["name"];
    }
    else{
        return "";
    }
}

function query($sql){
    $con = conn();
    if(mysqli_query($con,$sql)){
        return true;
    }else{
        die("Query fail....".mysqli_error($con));
    }
}

function fetchAll($sql){
    $con = conn();
    $query = mysqli_query($con,$sql);
    $totalRow = mysqli_num_rows($query);
    $rows = [];
    while($row = mysqli_fetch_assoc($query)){
        array_push($rows,$row);
    }
    return [$rows,$totalRow];
}

function textFilter($text){
    $text = trim($text);
    $text = htmlentities($text,ENT_QUOTES);
    $text = stripcslashes($text);
    return $text;
}

// insert Data to DB

function addContact($name,$phone,$email,$photo){
    global $url;
    $sql = "INSERT INTO `contacts`(`name`, `phone`, `email`, `photo`) VALUES ('$name','$phone','$email','$photo')";
    query($sql);
}

//get data from dB
function getContacts(){
    $sql = "SELECT * FROM contacts ORDER BY id DESC";
    return fetchAll($sql);
}


//create contact
function createNew(){
    global $supportFileType;
    $name = "";
    $phone ="";
    $email = "";
    $file ="";
    $errorStatus = 0;

    // name validation
    if(empty($_POST["name"])){
        setError("name","Name is required!");
        $errorStatus = 1;
    }else if(strlen($_POST["name"]) < 5){
        setError("name","Name is too short!");
        $errorStatus = 1;
    }else if(strlen($_POST["name"]) > 20){
        setError("name","Name is too long!");
        $errorStatus = 1;
    }else if(!preg_match("/^[a-zA-Z-' ]*$/",$_POST["name"])) {
        setError("name","Name is unavailable!");
        $errorStatus = 1;
    }else{
        $name = textFilter($_POST["name"]);
    }
    //phone validation
    if(empty($_POST["phone"])){
        setError("phone","Phone number is required!");
        $errorStatus = 1;
    }else if(!preg_match("/^[0-9-' ]*$/",$_POST["phone"])) {
        setError("phone","Phone number is unavailable!");
        $errorStatus = 1;
    }else{
        $phone = textFilter($_POST["phone"]);
    }

    //email validation
    if(empty($_POST["email"])){
        setError("email","Email is required!");
        $errorStatus = 1;
    }else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        setError("email","Email format is incorrect!");
        $errorStatus = 1;
    }else{
        $email = textFilter($_POST["email"]);
    }

    //file validation
    if(empty($_FILES["upload"]["name"])){
        setError("upload","File is required!");
        $errorStatus = 1;
    }else if(!(in_array($_FILES["upload"]["type"],$supportFileType))) {
        setError("upload","Upload file format is unavailable!");
        $errorStatus = 1;
    }else{
        $file = uniqid().$_FILES["upload"]["name"];
        if($file){
            $tempFile = $_FILES['upload']['tmp_name'];
            $fileType = $_FILES["upload"]["type"];
            $saveFolder = "store/";
            move_uploaded_file($tempFile,$saveFolder.$file);
        }
    }

    if(!$errorStatus){
        addContact($name,$phone,$email,$file);
    }

}