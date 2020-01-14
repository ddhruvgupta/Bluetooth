# @Author:Dhruv gupta
# Class: CSC 6220
# Project

import socket
import sys
import _thread
import connection
import json

port = 5100;
faculty = list() #list of mac addresses to search for - obtained from database
availability = dict() #dictionary of mac address availability

def handle(client_socket, address):
    val = client_socket.recv(2048).decode()
    results = json.loads(val)
    update(results) #updates database with current availability information
    faculty = update_list() #updates the list of devices to search for
    send_data = json.dumps(faculty)
    client_socket.send(send_data.encode())
    print('closing connection with: '+ str(address))
    client_socket.close()


def update(results):
    for result in results:
        avail(result,results[result])

def avail(stats,value):
    if (value == 1):
        sql = ("update current_availability set availability=1 where mac = ")
        data = (str(stats))
        print(stats)
        sql = sql+"'"+data+"'"
        print(sql)
        connection.cursor.execute(sql)
        if(connection.cursor.rowcount==1):
            logging(stats,value)
        connection.mydb.commit()
        print("Available")
    else:
        sql = ("update current_availability set availability=0 where mac = ")
        data = (str(stats))
        print(stats)
        sql = sql+"'"+data+"'"
        print(sql)
        connection.cursor.execute(sql)
        if(connection.cursor.rowcount==1):
            logging(stats,value)
        connection.mydb.commit()
        print("Unavailable")


def update_list():
    newList = list()
    sql = ("select mac from current_availability")
    connection.cursor.execute(sql)
    result =connection.cursor.fetchall()

    for mac in result:
        newList.append(mac[0])
    return newList


def logging(stats,value):
    sql = ("insert into logs (mac,availability) values ('")
    data = (str(stats))
    sql = sql+data+"',"+str(value)+")"
    connection.cursor.execute(sql)


serverSocket = socket.socket(socket.AF_INET,socket.SOCK_STREAM);
serverSocket.bind(('192.168.10.108',port));
print('Starting up on ',serverSocket);
serverSocket.listen(1);
print('the server is ready to receive')

    # Data is read from the connection with recv()
while True:
    client_socket, address = serverSocket.accept()
    print ("request from the ip",address[0])

    # Starts a new thread with every connection the server recives.
    _thread.start_new_thread(handle, (client_socket, address))
