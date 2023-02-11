# CGX#4: Ascii Encoding

Computers can only work with numbers.
We need a mapping, for converting numbers to written characters, to display text to humans.
The [ASCII](https://en.wikipedia.org/wiki/ASCII)
[encoding](../README.md)
was one of the first encoding to solve this problem.


## ASCII

 - 1 byte per character.
 - Original 7 bit + 1 bit [checksum]()
 - [ASCII Table](https://www.asciitable.com/)
 

## Other encodings
 - C64 Screencode (A=1, B=2, ...)
 - 8bit ASCII / extended ASCII
 - Win ISO
 - Unicode with UTF 8/16/32


## PHP Implementation
 - number to letter (chr())
 - letter to number (ord())
 - string encodings in PHP
