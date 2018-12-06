import bluetooth
import os
import time

try:
    while(True):
        print ("performing inquiry...")
        nearby_devices = bluetooth.discover_devices(lookup_names = True)
        print(nearby_devices)
        #time.sleep(60)
##        for addr, name in nearby_devices:
##            for services in bluetooth.find_service(address = addr):
##                print (" Name: %s" % (services["name"]))
##                print (" Description: %s" % (services["description"]))
##                print (" Protocol: %s" % (services["protocol"]))
##                print (" Provider: %s" % (services["provider"]))
##                print (" Port: %s" % (services["port"]))
##                print (" Service id: %s" % (services["service-id"]))
##                print ()
except KeyboardInterrupt:
    print('interrupted!')
