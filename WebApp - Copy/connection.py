import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="newuser",
  passwd="password",
  database='networking_project'
)
cursor = mydb.cursor()
