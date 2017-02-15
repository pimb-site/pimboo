<?php

$newname = uniqid().'.jpeg';

$target = $newname;
move_uploaded_file( $_FILES['filedata']['tmp_name'], $target);

?>