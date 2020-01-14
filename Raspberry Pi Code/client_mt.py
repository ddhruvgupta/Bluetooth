# @Author:Dhruv gupta
# Class: CSC 6220
# Homework 2

import socket
import json

def send(data):
    serverName = '192.168.10.111'
    serverPort = 5100;
    clientSocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    clientSocket.connect((serverName,serverPort))

    val = json.dumps(data)
    clientSocket.send(val.encode())
    newlist = clientSocket.recv(2048).decode()
    print(newlist)
    bt_addr = json.loads(newlist)
    #print('From server:', modifiedSentence.decode())
    
    clientSocket.close()
    return bt_addr
