import mysql.connector
import datetime

def check_data_integrity(cursor1, cursor2):
    """
    Compare records between db1 and db2 to ensure they match exactly.
    Logs discrepancies found.
    """
    # Fetch data from both databases
    cursor1.execute("SELECT id, name, email FROM users")
    users_db1 = cursor1.fetchall()
    
    cursor2.execute("SELECT id, name, email FROM users")
    users_db2 = cursor2.fetchall()
    
    discrepancies = []
    
    # Check records in db1 not in db2
    for user in users_db1:
        cursor2.execute("SELECT * FROM users WHERE id = %s", (user['id'],))
        db2_user = cursor2.fetchone()
        if db2_user is None:
            discrepancies.append(f"Missing record in DB2: {user}")
        elif user != db2_user:
            discrepancies.append(f"Discrepancy found in DB2 for user ID {user['id']}")

    # Check records in db2 not in db1
    for user in users_db2:
        cursor1.execute("SELECT * FROM users WHERE id = %s", (user['id'],))
        db1_user = cursor1.fetchone()
        if db1_user is None:
            discrepancies.append(f"Missing record in DB1: {user}")
        elif user != db1_user:
            discrepancies.append(f"Discrepancy found in DB1 for user ID {user['id']}")

    return discrepancies

# Wrap the entire code inside a try block to handle exceptions properly
try:
    # ✅ Connect to DB1
    db1 = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="db1",
        port=4306,
        unix_socket="/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock"
    )
    cursor1 = db1.cursor(dictionary=True)

    # ✅ Connect to DB2
    db2 = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="db2",
        port=4306,
        unix_socket="/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock"
    )
    cursor2 = db2.cursor(dictionary=True)

    # 📝 Log tables in DB1
    cursor1.execute("SHOW TABLES")
    tables = cursor1.fetchall()
    print("📋 Tables in db1:", [list(t.values())[0] for t in tables])

    # 🔁 Sync from DB1 → DB2
    cursor1.execute("SELECT * FROM users")
    users_db1 = cursor1.fetchall()

    synced_to_db2 = 0
    for user in users_db1:
        cursor2.execute("SELECT id FROM users WHERE id = %s", (user['id'],))
        if cursor2.fetchone() is None:
            cursor2.execute("INSERT INTO users (id, name, email) VALUES (%s, %s, %s)",
                            (user['id'], user['name'], user['email']))
            synced_to_db2 += 1
    db2.commit()

    # 🔁 Sync from DB2 → DB1
    cursor2.execute("SELECT * FROM users")
    users_db2 = cursor2.fetchall()

    synced_to_db1 = 0
    for user in users_db2:
        cursor1.execute("SELECT id FROM users WHERE id = %s", (user['id'],))
        if cursor1.fetchone() is None:
            cursor1.execute("INSERT INTO users (id, name, email) VALUES (%s, %s, %s)",
                            (user['id'], user['name'], user['email']))
            synced_to_db1 += 1
    db1.commit()

    # ✅ Data Integrity Check
    discrepancies = check_data_integrity(cursor1, cursor2)
    
    if discrepancies:
        print(f"[{datetime.datetime.now()}] ❌ Discrepancies found:")
        for discrepancy in discrepancies:
            print(discrepancy)
    else:
        print(f"[{datetime.datetime.now()}] ✅ Data Integrity Check passed. No discrepancies found.")

    # ✅ Log the sync status
    now = datetime.datetime.now()
    print(f"[{now}] ✅ Synced {synced_to_db2} records from DB1 → DB2")
    print(f"[{now}] 🔁 Synced {synced_to_db1} records from DB2 → DB1")

except mysql.connector.Error as err:
    # Handle MySQL connection errors
    print(f"❌ MySQL Error: {err}")

except Exception as e:
    # Catch any other exceptions
    print(f"❌ An error occurred: {e}")
