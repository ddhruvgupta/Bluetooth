#@Author: Dhruv Gupta
#CSC 6220 Project

import os
import sys
import time 
import bluetooth
import client_mt

bt_addr = list()
bt_addr= ['48:A9:1C:E7:9A:22']
while True:
    #list of bluetooth addresses to check should be updated with a list from a server every so often
    

    #dictionary to keep track of status of devices; this should be returned to the server as the result 
    status = dict()

    for bt in  bt_addr:
        count = 0
        present = 0
        while count<3:
            count+=1
            result = os.popen('sudo l2ping -s 1 -c 1 ' + bt).read()
            print(result)
            if (result != ''):
                present+=1
        
        if (present>0):
            status[bt] = 1
        else:
            status[bt] = 0
            
    print (status)
    bt_addr = client_mt.send(status)
    print("Updated address list: "+ str(bt_addr) )
    time.sleep(60)
        
            
