<?php
/**
 * The PermutationGenerator Java class systematically generates permutations. It relies on the fact that any set with n
 * elements can be placed in one-to-one correspondence with the set {1, 2, 3, ..., n}. The algorithm is described by
 * Kenneth H. Rosen, Discrete Mathematics and Its Applications, 2nd edition (NY: McGraw-Hill, 1991), pp. 282-284.
 * <p/>
 * The class is very easy to use. Suppose that you wish to generate all permutations of the strings "a", "b", "c", and
 * "d". Put them into an array. Keep calling the permutation generator's {@link #getNext ()} method until there are no
 * more permutations left. The {@link #getNext ()} method returns an array of integers, which tell you the order in
 * which to arrange your original array of strings. Here is a snippet of code which illustrates how to use the
 * PermutationGenerator class.
 * <pre>
 * int[] indices;
 * String[] elements = {"a", "b", "c", "d"};
 * PermutationGenerator x = new PermutationGenerator (elements.length);
 * StringBuffer permutation;
 * while (x.hasMore ()) {
 * permutation = new StringBuffer ();
 * indices = x.getNext ();
 * for (int i = 0; i < indices.length; i++) {
 * permutation.append (elements[indices[i]]);
 * }
 * System.out.println (permutation.toString ());
 * }
 * </pre>
 * One caveat. Don't use this class on large sets. Recall that the number of permutations of a set containing n elements
 * is n factorial, which is a very large number even when n is as small as 20. 20! is 2,432,902,008,176,640,000.
 * <p/>
 * NOTE: This class was taken from the internet, as posted by Michael Gilleland on <a
 * href="http://www.merriampark.com/perm.htm">this website</a>. The code was posted with the following comment: "The
 * source code is free for you to use in whatever way you wish."
 *
 * @author Michael Gilleland, Merriam Park Software (http://www.merriampark.com/index.htm)
 * 
 * Converted to PHP by gizmore
 */
class GWF_Permutation
{
	private $n;
	private $a;
	private $numLeft;
	private $total;
//	private int[] a;
//	private BigInteger numLeft;
//	private BigInteger total;

	//-----------------------------------------------------------
	// Constructor. WARNING: Don't make n too large.
	// Recall that the number of permutations is n!
	// which can be very large, even when n is as small as 20 --
	// 20! = 2,432,902,008,176,640,000 and
	// 21! is too big to fit into a Java long, which is
	// why we use BigInteger instead.
	//----------------------------------------------------------
	public function __construct($n)
	{
		if ($n < 1)
		{
			throw new Exception('IllegalArgumentException', -1);
		}
		$this->n = $n;
		$this->a = array();
		$this->total = self::getFactorial($n);
		$this->reset();
	}

	//------
	// Reset
	//------
	public function reset()
	{
		for ($i = 0; $i < $this->n; $i++)
		{
			$this->a[$i] = $i;
		}
		$this->numLeft = $this->total;
	}

	//------------------------------------------------
	// Return number of permutations not yet generated
	//------------------------------------------------

	public function getNumLeft()
	{
		return $this->numLeft;
	}

	//------------------------------------
	// Return total number of permutations
	//------------------------------------

	public function getTotal()
	{
		return $this->total;
	}

	//-----------------------------
	// Are there more permutations?
	//-----------------------------

	public function hasMore()
	{
		return bccomp($this->numLeft, '0') === 1;
	}

	//------------------
	// Compute factorial
	//------------------

	public static function getFactorial($n)
	{
		$result = '1';
		for ($i = $n; $i > 1; $i--)
		{
			$result = bcmul($result, $i);
		}
		return $result;
	}

	//--------------------------------------------------------
	// Generate next permutation (algorithm from Rosen p. 284)
	//--------------------------------------------------------

	public function getNext()
	{
		if ($this->numLeft === $this->total)
		{
			$this->numLeft = bcsub($this->numLeft, '1');
			return $this->a;
		}

		// Find largest index j with a[j] < a[j+1]
		$j = count($this->a) - 2;
		while ($this->a[$j] > $this->a[$j + 1])
		{
			$j--;
		}

		// Find index k such that a[k] is smallest integer
		// greater than a[j] to the right of a[j]
		$k = count($this->a) - 1;
		while ($this->a[$j] > $this->a[$k])
		{
			$k--;
		}

		// Interchange a[j] and a[k]
		$temp = $this->a[$k];
		$this->a[$k] = $this->a[$j];
		$this->a[$j] = $temp;

		// Put tail end of permutation after jth position in increasing order
		$r = count($this->a) - 1;
		$s = $j + 1;

		while ($r > $s)
		{
			$temp = $this->a[$s];
			$this->a[$s] = $this->a[$r];
			$this->a[$r] = $temp;
			$r--;
			$s++;
		}

		$this->numLeft = bcsub($this->numLeft, '1');
		return $this->a;
	}
}

