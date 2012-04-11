#!/usr/bin/python

import sys
import os

# Your main objective is to return 0
def main(argv):
	if not os.path.exists(argv):
		return 1

	print('opening '+argv)
	gizmore = open(argv)
	jjk = ''.join(gizmore.readlines())
	gizmore.close()
	print('closed')

	if not os.path.exists(argv):
		print('You are l33t')
		return 0
	else:
		spaceone = open(argv)
		kwisatz = ''.join(spaceone.readlines())
		spaceone.close()
		if jjk != kwisatz:
			print('You are a winner')
			return 0
	return 1

def sanitize_arg(value):
	# no symlinks, etc. please
	value = os.path.realpath(value)
	while -1 != value.find('proc'):
		value = value.replace('proc', '')
	return value

if __name__ == "__main__":
	rc = 1
	try:
		if len(sys.argv[1]) > 1:
			rc = main(sanitize_arg(sys.argv[1]))
	except:
		rc = 1
	sys.exit(rc)
