<?php

#$im_name = "/home/piotr/Sites/workspace-symfony/pickture/web/uploads/documents/".$image->getPath();

$path ='/home/piotr/Sites/workspace-symfony/pickture/src/PublicBundle/Python/predict.py';
exec("python ".$path." 2>&1", $out, $status);

print_r($out[0]);