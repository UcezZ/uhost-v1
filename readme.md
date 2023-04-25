# uHost v1
### MIREA-related project
Contains PHP powered first version of project and API for v2

Step-by-step manual:
- Install MS SQL Server 2012 or higher
- Create MS SQL database, tables and procedures. Make sure you granted EXECUTE permission for all procedures for the PHP credentials
- Install PHP 8 or higher
- Install `sqlsrv` library compatible with your PHP and MSSQL
- Install and configure ODBC driver for MSSQL if required
- Configure your web engine, restrict access to `*/private/*` folders
- Create `/private/sql.json` using template `/private/sql.json.example`
- Main page should be available on /index.php of your host