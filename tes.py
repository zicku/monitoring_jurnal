import mysql.connector

db = mysql.connector.connect(
    host="localhost",
    username="monito29_admin",
    password="monito29_admin",
    database="monito29_db"
)


cursor = db.cursor()
cursor.execute("DELETE FROM jurnal")
db.commit()
db.close()