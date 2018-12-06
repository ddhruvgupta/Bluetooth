import bluetooth

bd_addr = "48:A9:1C:E7:9A:21"

port = 1

sock=bluetooth.BluetoothSocket( bluetooth.RFCOMM )
sock.connect((bd_addr, port))

sock.send("hello!!")

sock.close()