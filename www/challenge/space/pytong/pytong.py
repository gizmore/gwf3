#!/usr/bin/python

import sys
import os

# Your main objective is to return True
def main(argv):
	# You have to give me an valid file!
	if not os.path.exists(argv):
		print('sorry file "%s" does not exists' % argv)
		return False

	# We are opening the file here and store the content in 'jjk'
	print('opening '+argv)
	gizmore = open(argv)
	jjk = gizmore.read()
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
		kwisatz = spaceone.read()
		spaceone.close()

		# Does the content differs from old content?
		if jjk != kwisatz:
			# content differs so return True
			print('You are a winner')
			return True
	return False

def validate_arg(value):
	# We also want to prevent some noobish solutions
	for ipattern in ['proc', 'uptime', 'tmp', 'random', 'full', 'zero', 'null']:
		if ipattern in value:
			raise ValueError('nononono: hacking is not allowed')

# Call main() when running file directly
if __name__ == "__main__":
	if len(sys.argv) != 2:
		print('wrong argcount')
		sys.exit(1)

	rc = 2
	try:
		# Objective: return True here!
		validate_arg(sys.argv[1])
		success = main(sys.argv[1])
	except:
		print('an Exception occured: corrupted file or no file permissions?')
	else:
		rc = 0 if success else 2
	sys.exit(rc)
