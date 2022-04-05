<?php

$url = "http://".$_SERVER["HTTP_HOST"];

$supportFileType = ["image/png","image/jpeg"];

function conn(){
    return mysqli_connect("localhost","root","", "contacts");
};