#!/usr/bin/python
import sys
import os
import os.path

SOLUTION = "/home/level/12/solution.txt"


# Your main objective is to return True
def main(filepath):
	# We want to prevent some noobish solutions
	if any(ipattern in filepath for ipattern in ('proc', 'uptime', 'tmp', 'random', 'full', 'zero', 'null')):
		raise ValueError('nononono: hacking is not allowed')

	# You have to give me an valid file!
	if not os.path.exists(filepath):
		raise ValueError('sorry file "%s" does not exists' % filepath)

	# We are opening the file here and store the content in 'jjk'
	print('opening %s' % filepath)
	with open(filepath) as gizmore:
		jjk = gizmore.read()
	print('closed')

	# The file was closed, does it still exists?
	if not os.path.exists(filepath):
		# The file does not exists anymore, you have found a solution
		print('You are l33t')
		return True
	else:
		# Ok, we will reopen the file and store its content in 'kwisatz'
		with open(filepath) as spaceone:
			kwisatz = spaceone.read()

		# Does the content differs from old content?
		if jjk != kwisatz:
			# content differs so return True
			print('You are a winner')
			return True

	raise ValueError('fail...')


if __name__ == "__main__":
	if len(sys.argv) < 2:
		print('wrong argcount')
		sys.exit(1)

	try:
		# Objective: return True here!
		success = main(sys.argv[1])
	except (ValueError, OSError, IOError) as exc:
		print('%s' % (exc,))
		sys.exit(3)
	else:
		#os.setuid(os.geteuid())
		os.setgid(os.getegid())
		with open(SOLUTION) as fd:
			print(fd.read())
