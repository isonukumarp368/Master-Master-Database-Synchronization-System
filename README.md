# Master–Master Database Synchronization System

### Real-time synchronization between two MySQL databases using Python, PHP, and Shell scripting.

This project demonstrates how to maintain **data consistency across two master MySQL databases** using a combination of Python automation, PHP web interface, and Linux scripting.  
It enables administrators to **monitor, trigger, and verify synchronization** between multiple databases through a secure and interactive dashboard.

---

## 🧩 Overview

The **Master–Master Database Synchronization System** is designed for organizations that require high data availability and redundancy across distributed databases.  
It ensures that **updates made in one database are automatically reflected in the other** using a combination of Python synchronization scripts and web-based management tools.

### 🔑 Key Features
- **Real-time sync** between two MySQL databases (db1 ↔ db2)
- **Admin dashboard** to trigger synchronization and monitor logs
- **Automated backup and recovery scripts**
- **Secure authentication system** for admin and user access
- **Detailed logging and status reporting**
- **Conflict detection and resolution logic**
- **Configurable database connections via PHP**

---

## ⚙️ Tech Stack

| Layer | Technologies Used |
|--------|------------------|
| **Frontend / Web Interface** | PHP, HTML, CSS |
| **Backend Logic** | Python, Shell Scripting |
| **Database** | MySQL (Master–Master configuration) |
| **Operating System** | Linux (Ubuntu preferred) |
| **Logging & Monitoring** | Custom `sync.log` file with timestamped operations |

---

## 🏗️ Project Structure

```
master-master-database-sync/
│
├── admin/                  # Admin panel (dashboard, trigger, logs)
├── user/                   # User login and dashboard
├── config/                 # Database connection files
├── scripts/                # Python scripts for synchronization
│   ├── sync.py
│   ├── test_sync.py
│
├── db/                     # SQL schema files (db1.sql, db2.sql)
├── logs/                   # Synchronization logs
├── index.php               # Landing page
├── readme.md               # Project documentation
└── test_db_connections.php # DB connection validation
```

---

## 🚀 How It Works

1. **Two MySQL databases (db1, db2)** are configured in a master–master replication setup.
2. **Python script (`sync.py`)** monitors and synchronizes data changes between both databases.
3. **PHP admin dashboard** provides real-time status monitoring and allows manual sync triggering.
4. **Shell commands** execute synchronization tasks and maintain logs.
5. **Logs and reports** are stored in `/logs/sync.log` for system analysis.

---

## 🧠 Implementation Highlights

- The system combines **Python automation** and **PHP web services** for a hybrid architecture.
- Uses **timestamp-based validation** to ensure accurate synchronization.
- Includes **error handling and rollback** in case of failed syncs.
- Logs stored in `/logs/sync.log` with structured event data.

---

## 🧰 Setup Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/isonukumarp368/master-master-database-sync.git
cd master-master-database-sync
```

### 2. Configure Databases
- Create two MySQL databases: `db1` and `db2`
- Import schema from:
  ```
  /db/db1.sql
  /db/db2.sql
  ```
- Update connection credentials in:
  ```
  /config/db1_config.php
  /config/db2_config.php
  /config/master_config.php
  ```

### 3. Run Synchronization Script
```bash
python3 scripts/sync.py
```

### 4. Launch the Web Interface
Host locally using XAMPP or LAMP stack:
```
http://localhost/master-master-database-sync/admin/login.php
```

---

## 🗃️ Log Files

All synchronization operations are logged at:
```
/logs/sync.log
```
Logs include timestamps, operation types, success/failure reports, and database actions.

---

## 🔒 Security Note
Before uploading to a public repository:
- Remove all passwords and sensitive credentials from `/config/`
- Add a `.gitignore` file containing:
  ```
  /logs/
  __pycache__/
  .DS_Store
  /config/*.php
  ```

---

## 📈 Future Improvements
- Add PostgreSQL and MongoDB cross-sync support  
- Real-time sync status visualization using AJAX or WebSocket  
- Cloud-based monitoring dashboard  
- Email/SMS alerts for sync failures  

---

## 📜 License
This project is open-source under the **MIT License**.  
Feel free to use and modify it for educational or research purposes.

---

## 👤 Author
**Sonu Kumar Pandit**  
- GitHub: [isonukumarp368](https://github.com/isonukumarp368)  
- LinkedIn: [linkedin.com/in/sonukrpandit](https://www.linkedin.com/in/sonukrpandit)
