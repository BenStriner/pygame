#create an 8 high 5 wide map
map=[]
for y in range(0,8):
  row=[]
  for x in range(0, 5):
    row.append(1)
  map.append(row)
data['map']=map

#create a single player on the map
#x, y, image
data['players']=[[2,2,1]]