--TEST--
FFI 017: Structure constraints & tags cleanup
--EXTENSIONS--
ffi
--INI--
ffi.enable=1
--FILE--
<?php
try {
    var_dump(FFI::new("struct X {void x();}"));
} catch (Throwable $e) {
    echo get_class($e) . ": " . $e->getMessage()."\n";
}
try {
    var_dump(FFI::new("struct X {struct X x;}"));
} catch (Throwable $e) {
    echo get_class($e) . ": " . $e->getMessage()."\n";
}
try {
    var_dump(FFI::new("struct X {struct X *ptr;}"));
} catch (Throwable $e) {
    echo get_class($e) . ": " . $e->getMessage()."\n";
}
?>
ok
--EXPECTF--
Deprecated: Calling FFI::new() statically is deprecated in %s on line %d
FFI\ParserException: function type is not allowed at line 1

Deprecated: Calling FFI::new() statically is deprecated in %s on line %d
FFI\ParserException: Struct/union can't contain an instance of itself at line 1

Deprecated: Calling FFI::new() statically is deprecated in %s on line %d
object(FFI\CData:struct X)#%d (1) {
  ["ptr"]=>
  NULL
}
ok
