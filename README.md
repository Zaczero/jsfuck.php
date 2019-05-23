# JSFuck.php `[]()!+`

This is an unofficial port of [jsfuck](https://github.com/aemkei/jsfuck) JavaScript library to PHP.

JSFuck is an esoteric and educational programming style based on the atomic parts of JavaScript. It uses only six different characters to write and execute code.

## 🔗 Download

* https://github.com/Zaczero/JSFuck.php/releases/latest

## ⛱️ Example

The following JavaScript code will execute `alert(1)`:

```js
[][(![]+[])[[+[]]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[[!+[]+!+[]]]+(![]+[])
[[!+[]+!+[]]]][([][(![]+[])[[+[]]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[[!+[]
+!+[]]]+(![]+[])[[!+[]+!+[]]]]+[])[[!+[]+!+[]+!+[]]]+(!![]+[][(![]+[])[[+[]]]
+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[[!+[]+!+[]]]+(![]+[])[[!+[]+!+[]]]])[+!
+[]+[+[]]]+([][[]]+[])[[+!+[]]]+(![]+[])[[!+[]+!+[]+!+[]]]+(!![]+[])[[+[]]]+(
!![]+[])[[+!+[]]]+([][[]]+[])[[+[]]]+([][(![]+[])[[+[]]]+([![]]+[][[]])[+!+[]
+[+[]]]+(![]+[])[[!+[]+!+[]]]+(![]+[])[[!+[]+!+[]]]]+[])[[!+[]+!+[]+!+[]]]+(!
![]+[])[[+[]]]+(!![]+[][(![]+[])[[+[]]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[
[!+[]+!+[]]]+(![]+[])[[!+[]+!+[]]]])[+!+[]+[+[]]]+(!![]+[])[[+!+[]]]]((![]+[]
)[[+!+[]]]+(![]+[])[[!+[]+!+[]]]+(!![]+[])[[!+[]+!+[]+!+[]]]+(!![]+[])[[+!+[]
]]+(!![]+[])[[+[]]]+([][[]]+[][(![]+[])[[+[]]]+([![]]+[][[]])[+!+[]+[+[]]]+(!
[]+[])[[!+[]+!+[]]]+(![]+[])[[!+[]+!+[]]]])[!+[]+!+[]+[!+[]+!+[]]]+[+!+[]]+([
[+[]]]+![]+[][(![]+[])[[+[]]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[[!+[]+!+[]
]]+(![]+[])[[!+[]+!+[]]]])[!+[]+!+[]+[+[]]])()
```

![](https://i.imgur.com/i2N4lWa.gif)

## 🏁 Getting Started

```php
// Load the library
require_once "jsfuck.php";

// Initialize the JSFuck class
// [*] optional parameter: location where compiled data should be stored
// [!] make sure that the directory is writtable
$jsf = new JSFuck("jsfuck.data");

// Encode JavaScript
$encoded = $jsf->Encode("alert(1)");

// [*] optional parameter: wrap the code with eval()
$encEval = $jsf->Encode("alert(1)", true);
```

## ☕ Support me

* Bitcoin: `35n1y9iHePKsVTobs4FJEkbfnBg2NtVbJW`

## 📎 License

MIT License

Copyright (c) 2019 Kamil Monicz

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
