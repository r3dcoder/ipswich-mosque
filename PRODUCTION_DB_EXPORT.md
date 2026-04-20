# Production Database Export Guide

This guide explains how to export your development database and import it into your production MySQL server.

## Method 1: Using mysqldump (Recommended)

### Step 1: Export Development Database

```bash
# Export the entire database
mysqldump -u [username] -p [database_name] > ipswich_mosque_backup.sql

# Example with your database
mysqldump -u root -p ipswich_mosque > ipswich_mosque_backup.sql

# Export with additional options for better compatibility
mysqldump -u root -p \
  --single-transaction \
  --routines \
  --triggers \
  --add-drop-table \
  --create-options \
  --disable-keys \
  --extended-insert \
  --quick \
  ipswich_mosque > ipswich_mosque_backup.sql
```

### Step 2: Transfer File to Production Server

```bash
# Using SCP (Secure Copy)
scp ipswich_mosque_backup.sql user@production-server:/path/to/destination/

# Using SFTP
sftp user@production-server
put ipswich_mosque_backup.sql
exit

# Or download from your local machine if you have direct access
```

### Step 3: Import to Production Database

```bash
# Create the database first (if it doesn't exist)
mysql -u [prod_username] -p -e "CREATE DATABASE IF NOT EXISTS ipswich_mosque_production;"

# Import the database
mysql -u [prod_username] -p ipswich_mosque_production < ipswich_mosque_backup.sql

# Example
mysql -u root -p ipswich_mosque_production < ipswich_mosque_backup.sql
```

## Method 2: Using Laravel Artisan Commands

### Step 1: Install Laravel Database Tools

```bash
# Install the package for database export
composer require spatie/laravel-db-snapshots
```

### Step 2: Create Export Command

```bash
# Create a database snapshot
php artisan db:snapshot:create development_backup

# Export to SQL file
php artisan db:snapshot:export development_backup ipswich_mosque_export.sql
```

### Step 3: Import to Production

```bash
# Transfer the file to production
scp storage/snapshots/ipswich_mosque_export.sql user@production:/path/

# Import on production
mysql -u [prod_user] -p ipswich_mosque_production < ipswich_mosque_export.sql
```

## Method 3: Using phpMyAdmin

### Step 1: Export from Development

1. Open phpMyAdmin on your development server
2. Select your database (`ipswich_mosque`)
3. Click "Export" tab
4. Choose "Custom" export method
5. Select all tables
6. Set format to "SQL"
7. Check these options:
   - Add DROP TABLE / VIEW / PROCEDURE / FUNCTION / EVENT statement
   - Add AUTO_INCREMENT value
   - Enclose table and column names with backquotes
   - Add CREATE DATABASE statement
8. Click "Go" to download the SQL file

### Step 2: Import to Production

1. Open phpMyAdmin on your production server
2. Create a new database (e.g., `ipswich_mosque_production`)
3. Select the new database
4. Click "Import" tab
5. Upload your SQL file
6. Click "Go" to import

## Method 4: Using MySQL Workbench

### Step 1: Export Schema and Data

1. Open MySQL Workbench
2. Connect to your development database
3. Go to Server → Data Export
4. Select all schemas or specific tables
5. Choose export options:
   - Export to Self-Contained File
   - Include Create Schema
   - Include Create Dump Events
   - Include Create Dump Routines
   - Include Create Dump Triggers
   - Include Create Dump Views
6. Start Export

### Step 2: Import to Production

1. Connect to your production MySQL server
2. Go to Server → Data Import
3. Select "Import from Self-Contained File"
4. Choose your exported file
5. Start Import

## Production Environment Setup

### Step 1: Update .env File

Update your production `.env` file with the correct database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=your-production-host
DB_PORT=3306
DB_DATABASE=ipswich_mosque_production
DB_USERNAME=your_production_username
DB_PASSWORD=your_production_password
```

### Step 2: Run Migrations (if needed)

```bash
# Run any new migrations
php artisan migrate

# Seed if needed
php artisan db:seed
```

### Step 3: Clear Cache

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan cache:clear
```

## Database Structure Reference

Your current database includes these tables:

### Core Tables
- `users` - Admin users
- `prayer_times` - Prayer times data
- `ramadan_settings` - Ramadan configuration
- `ramadan_daily_times` - Daily Ramadan times
- `ramadan_events` - Ramadan events

### New Tables (Added)
- `mosque_settings` - Website settings
- `newsletter_subscribers` - Email subscribers
- `notices` - Notice board posts
- `newsletters` - Sent newsletters
- `donations` - Donation records
- `contacts` - Contact form submissions
- `marriage_bookings` - Marriage booking requests
- `funeral_bookings` - Funeral booking requests
- `khutbahs` - Khutbah records
- `people` - Community members

## Security Considerations

### 1. Database User Permissions
```sql
-- Create a dedicated user for the application
CREATE USER 'mosque_app'@'localhost' IDENTIFIED BY 'secure_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON ipswich_mosque_production.* TO 'mosque_app'@'localhost';
FLUSH PRIVILEGES;
```

### 2. Backup Strategy
```bash
# Create automated backups
mysqldump -u root -p --single-transaction --routines --triggers ipswich_mosque_production | gzip > /backups/mosque_$(date +%Y%m%d).sql.gz

# Set up cron job for daily backups
0 2 * * * /path/to/backup_script.sh
```

### 3. SSL Connection
```env
# Enable SSL in production
DB_SSL=true
MYSQL_SSL_CA=/path/to/ca-cert.pem
MYSQL_SSL_CERT=/path/to/client-cert.pem
MYSQL_SSL_KEY=/path/to/client-key.pem
```

## Troubleshooting

### Common Issues

1. **Character Encoding Problems**
   ```sql
   -- Check character set
   SHOW CREATE DATABASE ipswich_mosque_production;
   
   -- Fix if needed
   ALTER DATABASE ipswich_mosque_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. **Foreign Key Constraints**
   ```sql
   -- Disable constraints during import if needed
   SET FOREIGN_KEY_CHECKS = 0;
   -- Import your data
   SET FOREIGN_KEY_CHECKS = 1;
   ```

3. **Memory Issues with Large Databases**
   ```bash
   # Use chunked import
   mysql -u user -p --max-allowed-packet=1G database_name < large_file.sql
   ```

### Verification Steps

1. **Check Database Connection**
   ```bash
   php artisan tinker
   >>> DB::connection()->getPdo();
   ```

2. **Verify Tables**
   ```bash
   php artisan migrate:status
   ```

3. **Test Application**
   - Visit your website
   - Check if data loads correctly
   - Test forms and functionality

## Quick Export Script

Create a shell script for easy exports:

```bash
#!/bin/bash
# export_db.sh

DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="ipswich_mosque"
BACKUP_DIR="/backups"
FILE_NAME="${BACKUP_DIR}/mosque_backup_${DATE}.sql"

echo "Exporting database: $DB_NAME"
mysqldump -u root -p \
  --single-transaction \
  --routines \
  --triggers \
  --add-drop-table \
  --create-options \
  --disable-keys \
  --extended-insert \
  --quick \
  $DB_NAME > $FILE_NAME

if [ $? -eq 0 ]; then
    echo "Database exported successfully to: $FILE_NAME"
else
    echo "Database export failed!"
    exit 1
fi
```

Make it executable:
```bash
chmod +x export_db.sh
./export_db.sh
```

This comprehensive guide covers multiple methods for exporting your database to production, with security considerations and troubleshooting tips included.