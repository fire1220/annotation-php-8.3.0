--TEST--
Bug #78793: Use-after-free in exif parsing under memory sanitizer
--EXTENSIONS--
exif
--FILE--
<?php
$f = __DIR__ . "/bug77950.tiff";
for ($i = 0; $i < 10; $i++) {
    @exif_read_data($f);
}
?>
===DONE===
--EXPECT--
===DONE===
