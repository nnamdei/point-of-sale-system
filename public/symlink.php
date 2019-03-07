<?php
$targetFolder = '/home/y71ul2b2argw/public_html/wesanigroup.com/ims/storage/app/public';

$linkFolder = '/home/y71ul2b2argw/public_html/wesanigroup.com/ims/public/storage';

symlink($targetFolder, $linkFolder);

echo 'Symblink created!';

?>