data={'usercommand':'right','levelcommands':[],'level':{'players':[[0,0,0],[0,1,1]]}, 'cont':1, 'step':1}





cmd = data['usercommand']
#if player located at treasure then win
if(data['level']['players'][0][0] == data['level']['players'][1][0] and data['level']['players'][0][1] == data['level']['players'][1][1]):
  data['cont']=0
  data['levelcommands'].append(['win'])
#if 10 steps in then lose
elif data['step'] > 10:
  data['cont'] = 0
  data['levelcommands'].append(['lose'])
elif cmd == 'left' and data['level']['players'][0][0] > 0:
  data['levelcommands'].append(['move',0,-1,0])
elif cmd == 'right' and data['level']['players'][0][0] < 5:
  data['levelcommands'].append(['move',0,1,0])
elif cmd == 'up' and data['level']['players'][0][1] > 0:
  data['levelcommands'].append(['move',0,0,-1])
elif cmd == 'down' and data['level']['players'][0][1] < 8:
  data['levelcommands'].append(['move',0,0,1])
  
  
  
  

print(data['levelcommands'])