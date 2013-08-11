cmd = data['usercommand']
#if player located at treasure then win
if(data['level']['players'][0][0] == data['level']['players'][1][0] && data['level']['players'][0][1] == data['level']['players'][1][1]):
  data['cont']=0
  data['levelcommands'].append(['win'])
#if 10 steps in then lose
elif data['step'] > 10
  data['cont'] = 0
  data['levelcommands'].append(['lose'])
elif cmd == 'left' && data['level']['players'][0][0] > 0:
  data['levelcommands'].append(['move',0,-1,0])
elif cmd == 'right' && data['level']['players'][0][1] < 5:
  data['levelcommands'].append(['move',0,1,0])
elif cmd == 'up' && data['level']['players'][0][0] > 0:
  data['levelcommands'].append(['move',0,0,-1])
elif cmd == 'down' && data['level']['players'][0][0] < 8:
  data['levelcommands'].append(['move',0,0,1])
