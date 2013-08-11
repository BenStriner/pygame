cmd = data['usercommand']
if cmd == 'left':
  data['levelcommands'].append(['move',0,-1,0])
elif cmd == 'right':
  data['levelcommands'].append(['move',0,1,0])
elif cmd == 'up':
  data['levelcommands'].append(['move',0,0,-1])
elif cmd == 'down':
  data['levelcommands'].append(['move',0,0,1])

if data['step'] > 10
  data['cont'] = 0