#create an 8 high 5 wide map
map=[]
for y in range(0,8):
  row=[]
  for x in range(0, 5):
    if(x%2==0):
      row.append(4)
    else:
      row.append(3)
  map.append(row)
data['map']=map

#create a single player on the map and treasure chest
#x, y, image
data['players']=[[2,2,6],[3,5,7]]