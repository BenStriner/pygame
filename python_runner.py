#accepts a JSON string on standard input
#outputs a JSON string on standard output

#input:
#
#<code>[UserContent]</code><data>[DATA]</data>

#output:
#<level>
#	<map><row><tile>Floor</tile></row></map>
#	<players><player x=0 y=0 icon=Person></player></players>
#</level>

import json
import sys

#parse stdin as json
inputs = sys.stdin.read()
input = json.loads(inputs)

#get code and data
code = input['code']
data = input['data']

#execute code
exec(code)

#print 'data' variable to stdout as json
#json.dump(data, sys.stdout)
print(json.dumps(data))