#!/usr/bin/python

import sys
import os

# Your main objective is to return True
def main(argv):
	# You have to give me an valid file!
	if not os.path.exists(argv):
		print('sorry file does not exists: ' + argv)
		return False

	# We are opening the file here and store the content in 'jjk'
	print('opening '+argv)
	gizmore = open(argv)
	jjk = ''.join(gizmore.readlines())
	gizmore.close()
	print('closed')

	# The file was closed, does it still exists?
	if not os.path.exists(argv):
		# The file does not exists anymore, you have found a solution
		print('You are l33t')
		return True
	else:
		# Ok, we will reopen the file and store its content in 'kwisatz'
		spaceone = open(argv)
		kwisatz = ''.join(spaceone.readlines())
		spaceone.close()

		# Does the content differs from old content?
		if jjk != kwisatz:
			# content differs so return True
			print('You are a winner')
			return True
	return False

def sanitize_arg(value):
	# We also want to prevent some noobish solutions
	pattern = ['proc', '..', 'tmp', 'random', 'full', 'zero', 'null']
	for ipattern in pattern:
		while ipattern in value:
			value = value.replace(ipattern, '')
	for ipattern in pattern:
		if ipattern in value:
			return 'nononono: hacking is not allowed'
	
	return value

# Call main() when running file directly
if __name__ == "__main__":
	if len(sys.argv) != 2:
		print('wrong argcount')
		sys.exit(1)

	rc = 2
	try:
		# Objective: return True here!
		success = main(sanitize_arg(sys.argv[1]))
	except:
		print('an Exception occured: corrupted file or no file permissions?')
	else:
		rc = 0 if success else 2
	sys.exit(rc)
