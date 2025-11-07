import unittest
import mysql.connector

class TestSyncLogic(unittest.TestCase):
    def setUp(self):
        self.db1 = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="db1",
            port=4306,
            unix_socket="/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock"
        )
        self.db2 = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="db2",
            port=4306,
            unix_socket="/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock"
        )
        self.cursor1 = self.db1.cursor(dictionary=True)
        self.cursor2 = self.db2.cursor(dictionary=True)

    def tearDown(self):
        self.cursor1.close()
        self.cursor2.close()
        self.db1.close()
        self.db2.close()

    def test_connection_db1(self):
        self.assertIsNotNone(self.db1.is_connected())

    def test_connection_db2(self):
        self.assertIsNotNone(self.db2.is_connected())

    def test_user_table_exists(self):
        self.cursor1.execute("SHOW TABLES LIKE 'users'")
        self.assertTrue(self.cursor1.fetchone())

        self.cursor2.execute("SHOW TABLES LIKE 'users'")
        self.assertTrue(self.cursor2.fetchone())

    def test_sync_insert_and_count(self):
        # Insert dummy user into DB1
        test_id = 9999
        self.cursor1.execute("DELETE FROM users WHERE id = %s", (test_id,))
        self.cursor2.execute("DELETE FROM users WHERE id = %s", (test_id,))
        self.db1.commit()
        self.db2.commit()

        self.cursor1.execute("INSERT INTO users (id, name, email) VALUES (%s, %s, %s)",
                             (test_id, "Test User", "test@example.com"))
        self.db1.commit()

        # Now run sync.py (DB1 → DB2)
        import sync  # make sure sync.py is in the same folder

        # Check if user is copied to DB2
        self.cursor2.execute("SELECT * FROM users WHERE id = %s", (test_id,))
        result = self.cursor2.fetchone()
        self.assertIsNotNone(result)

        # Cleanup
        self.cursor1.execute("DELETE FROM users WHERE id = %s", (test_id,))
        self.cursor2.execute("DELETE FROM users WHERE id = %s", (test_id,))
        self.db1.commit()
        self.db2.commit()

if __name__ == '__main__':
    unittest.main()
