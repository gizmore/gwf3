# CGX:# javagdo

There is the plan that i'd want to show the world,
that java can be fun, slim and fast as well.
A re-implementation of phpgdo in Java.
It is possible and worth a try.
I am very fluent with Eclipse and Java,
and this combination is a dream team to me,
unless you go for Eclipse JEE extra Enterprise.
 - Stay tuned!
 
 
# DRAFT-104 


## GDT_SharedString


### A better String implementation

 - Java String is final
 - Comparisons are taking quite some time
 - String slicing is slow and memory inefficient
 
 
### GDT_Shtring :)

A shtring, on creation, checks all the existings Java Strings if he equals to one of them.
If so, he will have the same 20 bit ID as his friend.
String comparison is a cheap instruction.


 - 64 bit strings (soon 128?)
 - 
 - A *kind* of pointer
 - Backed by Java Strings
 -  4 bits type (16 types) (60 bits left)
 - 20 bits offset start (1M max strlen / offset)
 - 20 bits length (1M max strlen)
 - 20 bits id (max 1M Shtrings)
 
 
### What can we achieve with encoding textual data in 64 bit 
 - Memory efficiency?
 - Computational efficiency?
 

### GDT_Shtring Types

 1. Anagram - The string is an anagram and encodes 32 bit of entropy
 
 
### GDT_Shtring: Idea

This is just a draft.

(c)2022-2023
gizmore@wechall.net
