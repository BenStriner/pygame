if data['level']['players'][0][0] < data['level']['players'][1][0]:
	data['commands'].append('right')
elif data['level']['players'][0][0] > data['level']['players'][1][0]:
	data['commands'].append('left')
elif data['level']['players'][0][1] > data['level']['players'][1][1]:
	data['commands'].append('up')
elif data['level']['players'][0][1] < data['level']['players'][1][1]:
	data['commands'].append('down')
else:
	data['commands'].append('pass')
