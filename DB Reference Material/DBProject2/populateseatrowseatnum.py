import mysql.connector
import string
import keyring

# keyring password
pw = keyring.get_password('MySQL', 'root')
mydb = mysql.connector.connect(
    host='127.0.0.1',
    user='root',
    password='root',
    use_pure=True,
    database="Theater"
)


# generate the seat rows# generate the seat rows
def gen_seat_rows():
    rows = [x for x in string.ascii_uppercase if x < 'S' and 'I' not in x] + \
           [y * 2 for y in string.ascii_uppercase if y < 'I']
    return rows


seat_rows = [(z,) for z in gen_seat_rows()]


# generate the seat numbers
def gen_seat_nums():
    nums = [tuple(str(x)) for x in range(1, 10)]  # + [y for y in range(101, 127)]
    return nums


# seat_nums = [(z,) for z in gen_seat_nums()]

# create the cursor object
mycursor = mydb.cursor()

# iterate through the list and insert rows into the database
for x in seat_rows:
    sql = "INSERT INTO SeatRow (seatrow) values(%s)"
    mycursor.execute(sql, x)

# iterate through the list and insert rows into the database
for y in gen_seat_nums():
    sql = "INSERT INTO SeatNum (num) values(%s)"
    mycursor.execute(sql, y)

# commit the changes
mydb.commit()

# close the connection string
mydb.close()
