import mysql.connector
import keyring
import string

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


# generate the seat numbers
def gen_seat_nums():
    nums = [x for x in range(1, 16)] + [y for y in range(101, 127)]
    return nums


# populate the composite PK theater 'shell'
# a list of lists
theater = []
for row in gen_seat_rows():
    for num in gen_seat_nums():
        theater.append([row, num])


# generate a theater
def gen_theater(input_list):
    # add section
    for x in input_list:
        if len(x[0]) == 1:
            x.append("Main Floor")
        else:
            x.append("Balcony")

    # add side
    for x in input_list:
        if x[1] < 100:
            x.append("Middle")
        elif x[1] > 99 and x[1] % 2 == 0:
            x.append("Right")
        else:
            x.append("Left")

    # add pricing tier
    for x in input_list:
        if len(x[0]) > 1 and x[0] > 'E':
            x.append("Upper Balcony")
        elif (x[2] == "Balcony" and x[3] != "Middle") or x[1] > 106:
            x.append("Side")
        else:
            x.append("Orchestra")

    # add wheelchair
    for x in input_list:
        if x[0] in ['P', 'Q', 'R'] and x[1] > 108:
            x.append(1)
            # x.append("True")
        else:
            # x.append("False")
            x.append(0)

    # return generated theater list of lists
    return input_list


# function to remove seat/row combinations to meet auditorium specifications
def theater_rows_fix(list_of_lists, row_letters, middle_max, outer_max):
    fixed_list = [x for x in list_of_lists if x not in [y for y in list_of_lists if y[0] in row_letters
                                                        and y[3] == "Middle" and y[1] > middle_max] + [z for z in
                                                                                                       list_of_lists if
                                                                                                       z[0] in
                                                                                                       row_letters and
                                                                                                       z[
                                                                                                           1] > outer_max]]
    return fixed_list


# fix the theater list based upon the auditorium specifications
fix_tuples_list = [(['A'], 10, 114),
                   (['B', 'C'], 10, 116),
                   (['D', 'E'], 11, 116),
                   (['F'], 11, 118),
                   (['G', 'H', 'J'], 12, 118),
                   (['K', 'L', 'M'], 13, 120),
                   (['N'], 14, 120),
                   (['O', 'P'], 14, 122),
                   (['Q', 'R'], 15, 122),
                   (['AA'], 13, 124),
                   (['BB', 'CC'], 14, 124),
                   (['DD'], 14, 126),
                   (['EE', 'FF'], 10, 122),
                   (['GG'], 11, 120),
                   (['HH'], 11, 118)
                   ]

theater = gen_theater(theater)

# final corrected theater list of lists
for fix in fix_tuples_list:
    theater = theater_rows_fix(theater, fix[0], fix[1], fix[2])

theater = [tuple(x) for x in theater]
# create the cursor object
mycursor = mydb.cursor()

# iterate through the list and insert into seat
# for x in theater:
#     mycursor.execute(
#         # 'INSERT INTO seat VALUES("SeatRow", "SeatNumber", '
#         # '"Section", "Side", "PricingTier", "Wheelchair")'.format(x[0], x[1],
#         #                                                          x[2], x[3],
#         #                                                          x[4], x[5])
#         'INSERT INTO seat ("SeatRow", "SeatNumber", "Section", "Side", "PricingTier", "Wheelchair")' 'VALUES '
#         '(%s, %s, %s, %s, %s, %s)', (x[0], x[1], x[2], x[3], x[4], x[5], )
#     )


for x in theater:
    sql = "INSERT INTO seat (SeatRow, SeatNumber, Section, Side, PricingTier, Wheelchair) values(%s, %s, %s, %s, %s, %s)"
    # vals = (x[0], x[1], x[2], x[3], x[4], x[5])
    # vals = ('A', 2, 'Main Floor', 'Right', 'Orchestra', False)

    mycursor.execute(sql, x)

# commit the changes
mydb.commit()

# count the number of rows in the table
# mycursor.execute("select count * from seat")

for x in mycursor:
    print(x)

# close the connection string
mydb.close()
