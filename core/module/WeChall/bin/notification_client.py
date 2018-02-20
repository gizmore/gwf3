import socket, json

auth_key = 'ABC'
host = 'wechall.net'
port = 53452

sock = socket.socket()
sock.connect((host, port))

def send(data):
  sock.send(json.dumps(data) + '\n')

recv_buf = ''
def recv():
  global recv_buf

  while not '\n' in recv_buf:
    data = sock.recv(4096)
    if data == '':
      print 'EOF on socket!'
      sys.exit(1)

    recv_buf += data

  data, recv_buf = recv_buf.split('\n', 1)

  return json.loads(data)

send({'command': 'AUTHENTICATE', 'key': auth_key})
if recv()['result'] != 'OK':
  print 'authentication failed!'
  sys.exit(1)

send({'command': 'SUBSCRIBE', 'event': 'user.score'})
if recv()['result'] != 'OK':
  print 'could not subscribe!'
  sys.exit(1)

while True:
  msg = recv()
  if not 'event' in msg:
    continue
  
  event = msg['event']
  if event['type'] == 'user.score.update':
    print '{0} scored {1} points on {2} and now has a total of {3} points.'.format(
               event['user_name'],
               event['new_score'] - event['old_score'],
               event['site_name'],
               event['new_score'])
