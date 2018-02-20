import socket, threading, time, json, sys

publish_addr = 'localhost'
publish_port = 12354
notify_addr = '0.0.0.0'
notify_port = 53452

supported_events = [
  'user.score.update'
  ]

if len(sys.argv) != 2:
  print 'usage: {0} <key file>'.format(sys.argv[0])
  sys.exit(1)
key_file = sys.argv[1]


PROTOCOL_VERSION_MAJOR = 0
PROTOCOL_VERSION_MINOR = 1


running = True
def stop_everything():
  global running
  running = False


def check_key(key):
  f = open(key_file)
  try:
    while True:
      line = f.readline()
      if line == '':
        return False
      if line.strip() == key:
        return True
  finally:
    f.close()
  return False


class Subscriptions(object):
  def __init__(self):
    self.subs = ({},set([]))
    for event in supported_events:
      tmp = self.subs
      for part in event.split('.'):
        if not part in tmp[0]:
          tmp[0][part] = ({},set([]))
        tmp = tmp[0][part]

  def add(self, client, event):
    tmp = self.subs
    for part in event.split('.'):
      if not part in tmp[0]:
        return False
      tmp = tmp[0][part]
    tmp[1].add(client)
    return True
  
  def remove(self, client, event):
    tmp = self.subs
    for part in event.split('.'):
      if not part in tmp[0]:
        return False
      tmp = tmp[0][part]
    if not client in tmp[1]:
      return False
    tmp[1].remove(client)
    return True

  def remove_all(self, client, tmp = None):
    if tmp == None:
      tmp = self.subs

    tmp[1].discard(client)

    for part in tmp[0]:
      self.remove_all(client, tmp[0][part])

  def notify(self, data):
    event = data['type']

    tmp = self.subs
    clients = set([])
    clients |= tmp[1]
    for part in event.split('.'):
      if not part in tmp[0]:
        print 'received unknown event {0}'.format(repr(event))
        return
      tmp = tmp[0][part]
      clients |= tmp[1]

    for client in clients:
      client.notify(data)

subscriptions = Subscriptions()


class PublishServer(threading.Thread):
  def run(self):
    serv_sock = None

    try:
      serv_sock = socket.socket()
      serv_sock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
      serv_sock.bind((publish_addr, publish_port))
      serv_sock.listen(3)

      print 'PublishServer running...'
      while True:
        clnt_sock, clnt_addr = serv_sock.accept()

        # Handle client in separate thread? Connection is from same server now
        # and data is minimal, so I expect this to be quick enough...

        try:
          data = ''
          while True:
            newdata = clnt_sock.recv(4096)
            if newdata == '':
              break
            data += newdata
          print repr(clnt_addr), repr(data)
          data = json.loads(data)
          if 'type' in data:
            subscriptions.notify(data)

	finally:
          clnt_sock.close()

    finally:
      print 'PublishServer stopped.'
      if serv_sock != None:
        serv_sock.close()
      stop_everything()


class NotifyClient(threading.Thread):
  def __init__(self, sock, addr):
    threading.Thread.__init__(self)
    self.sock = sock
    self.addr = addr
    self.authenticated = False

  def respond(self, data):
    self.sock.send(json.dumps(data))
    self.sock.send('\n')

  def error(self, cmd_id, msg):
      reply = {}
      if cmd_id != None:
        reply['id'] = cmd_id
      reply['result'] = msg
      self.respond(reply)

  def notify(self, data):
      print 'Client {0}:{1} got event {2}'.format(self.addr[0], self.addr[1], repr(data))
      reply = {'event': data}
      self.respond(reply)

  def subscribe(self, event):
    if subscriptions.add(self, event):
      return True, None
    else:
      return False, 'UNKNOWN_EVENT'

  def unsubscribe(self, event):
    if subscriptions.remove(self, event):
      return True, None
    else:
      return False, 'NOT_SUBSCRIBED'

  def handle_cmd(self, cmd):
    cmd_id = None
    reply = {'result': 'OK'}

    try:
      cmd = json.loads(cmd)

      if 'id' in cmd:
        tmp_id = cmd['id']
        if type(tmp_id) != int or tmp_id < 0 or tmp_id > 0xffffffff:
          self.error(None, 'INVALID_CMD_ID')
          return

	cmd_id = tmp_id
        reply['id'] = cmd_id

      if not 'command' in cmd:
        self.error(cmd_id, 'INVALID_COMMAND')
        return
      cmd_cmd = cmd['command']

      if not self.authenticated:
        if cmd_cmd == 'AUTHENTICATE':
          if not 'key' in cmd or not check_key(cmd['key']):
            self.error(cmd_id, 'INVALID_KEY')
          else:
            self.authenticated = True
            self.respond(reply)
        else:
          self.error(cmd_id, 'NOT_AUTHENTICATED')
        return

      if cmd_cmd == 'PING':
        pass

      elif cmd_cmd == 'QUIT':
        self.respond(reply)
        self.sock.close()
        return

      elif cmd_cmd == 'VERSION':
        reply['version'] = '{0}.{1}'.format(PROTOCOL_VERSION_MAJOR, PROTOCOL_VERSION_MINOR)

      elif cmd_cmd == 'AUTHENTICATE':
        self.error(cmd_id, 'ALREADY_AUTHENTICATED')
        return
      
      elif cmd_cmd == 'SUBSCRIBE':
        if not 'event' in cmd:
          self.error(cmd_id, 'INVALID_EVENT')
          return
        event = cmd['event']
        ok, err = self.subscribe(event)
        if not ok:
          self.error(cmd_id, err)
          return
        print 'Client from {0}:{1} subscribed to {2}'.format(self.addr[0], self.addr[1], event)

      elif cmd_cmd == 'UNSUBSCRIBE':
        if not 'event' in cmd:
          self.error(cmd_id, 'INVALID_EVENT')
          return
        event = cmd['event']
        ok, err = self.unsubscribe(event)
        if not ok:
          self.error(cmd_id, err)
          return
        print 'Client from {0}:{1} unsubscribed from {2}'.format(self.addr[0], self.addr[1], event)
 
      else:
        self.error(cmd_id, 'UNKNOWN_COMMAND')
        return

      self.respond(reply)

    except Exception, e:
      print 'Exception in command handler for client {0}:{1}: {2}'.format(self.addr[0], self.addr[1], e)
      self.error(cmd_id, 'ERROR')

  def run(self):
    print 'Client from {0}:{1} connected...'.format(*self.addr)

    try:
      data = ''
      while True:
        newdata = self.sock.recv(4096)
        if newdata == '':
          break
        data += newdata
        cmds = data.split('\n')
        data = cmds.pop()
        for cmd in cmds:
          self.handle_cmd(cmd)

    finally:
      print 'Client from {0}:{1} terminated.'.format(*self.addr)
      self.sock.close()
      subscriptions.remove_all(self)


class NotifyServer(threading.Thread):
  def run(self):
    serv_sock = None

    try:
      serv_sock = socket.socket()
      serv_sock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
      serv_sock.bind((notify_addr, notify_port))
      serv_sock.listen(3)

      print 'NotifyServer running...'
      while True:
        clnt_sock, clnt_addr = serv_sock.accept()

        try:
          handler = NotifyClient(clnt_sock, clnt_addr)
	  handler.setDaemon(True)
          handler.start()
	finally:
          pass

    finally:
      print 'NotifyServer stopped.'
      if serv_sock != None:
        serv_sock.close()
      stop_everything()


pub_serv = PublishServer()
pub_serv.setDaemon(True)
pub_serv.start()

not_serv = NotifyServer()
not_serv.setDaemon(True)
not_serv.start()

# uhm.. yeah...
try:
  while running:
    time.sleep(1000)
finally:
  stop_everything()
