<?php
require 'tugas-2.1.php';
if (validateName($_POST, 'surname'))
    echo 'Data OK!';
else
    echo 'Data invalid!';
