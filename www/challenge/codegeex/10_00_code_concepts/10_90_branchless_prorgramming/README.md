# CGD#: Branchless Programming

In this lesson we will talk short about branchless programming.

Then I will present and explain a completely branch-free strcasecmp.0

The idea came to me last night, ohn 15.Feb.2023 in Peine, Germany.

Let's go!


## What means branchless.

 - CPU Performance
 - Execution Pipeline
 - Branch prediction

## gmxcmpbyte

The first step is to compare a single byte with %wiki%Branchless Programming%.


 - compare a single byte.
 - [PHP implementation](./GMX.php)
 - `ord()` is slow
 - No carry flag
 - %wi%ProC%
 

´´´
´´´
 
## gmxcmpint

 - carry flag
 - ASM

```
sgsg

```

## gmxmemcmp

 - 
 
## gmxstricmp

 - Just ignore some bits!
 - UTF8

 
## Epilogue

 - Be safe!
 - gizmore
