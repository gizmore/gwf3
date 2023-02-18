# CGD#: Branchless Programming

In this lesson we will talk short about branchless programming.

```
if(i == 0) goto 10: # JZ  10:
```

Then I will present and explain a completely branch-free strcasecmp.0

The idea came to me last night, ohn 15.Feb.2023 in Peine, Germany.

Let's go!


## What means branchless.

 - CPU Performance
 - Execution Pipeline
 - Branch prediction
 - Mispredictions are slow
 - echo $i ? 1 : 0; # ternary

##
 - Autoloader
 - Is there are branchless string comparison *possible*?
```
 if class start with "GDO\" goto loading it
if ($class[0]==G and $class[3] =="\\") # 2 ifs?
{
	include class
}
```

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
