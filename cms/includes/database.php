<?php

$connect = mysqli_connect('localhost', 'cms', 'guac', 'cms');

if (mysqli_connect_errno()) {
    exit('Connection to MySQL failed: ' . mysqli_connect_error());
}

