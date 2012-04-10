#!/usr/bin/python

import sys
import os

# Your main objective is to return 0
def main(argv):
	if len(argv) < 2 or not os.path.exists(argv[1]):
		return 1

	print('opening '+argv[1])
	gizmore = open(argv[1])
	jjk = ''.join(gizmore.readlines())
	gizmore.close()
	print('closed')

	if not os.path.exists(argv[1]):
		print('You are l33t')
		return 0
	else:
		spaceone = open(argv[1])
		kwisatz = ''.join(spaceone.readlines())
		if jjk != kwisatz:
			print('You are a winner')
			return 0
	return 1

if __name__ == "__main__":
	try:
		rc = main(sys.argv)
	except:
		rc = 1
	sys.exit(rc)
