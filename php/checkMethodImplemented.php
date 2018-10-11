<?php
/**
 * Check if a method is implemented in a class (not count inheritance).
 */

class C {}
class B extends C {
    public function funcB1() {}
    public function funcB2() {}
}
class A extends B {
    public function funcA() {}
    public function funcB2() {}
}

/**
 * Check if a method is implemented in a class.
 * @return boolean TRUE if method $methodName is implemented in class $className, FALSE otherwise.
 * if $methodName is implement in the parent class but not $className itself, then FALSE is returned.
 */
function checkMethodImplemented($className, $methodName)
{
	$reflectionClass = new ReflectionClass($className);
	$status = ($reflectionClass->getMethod($methodName)->class == $className);
	return $status;
}

assert(checkMethodImplemented('B', 'funcB1') == TRUE);
assert(checkMethodImplemented('A', 'funcB1') == FALSE);
assert(checkMethodImplemented('A', 'funcB2') == TRUE);
assert(checkMethodImplemented('A', 'funcA') == TRUE);
