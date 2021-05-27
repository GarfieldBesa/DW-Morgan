***IMPORT CSV FILE***

DEV SERVER: XAMPP v3.2.4
DB TOOL: phpMyAdmin
Technology used: PHP,MYSQL,HTML,CSS, JAVASCRIPT

*Initial Requirement is PostGreSQL, however I'm not yet familiar on this tool. Just to complete the 
application I used the tool which I'm currently familiar.

To run the application please follow the instructions listed below.
1. Install and Setup XAMPP Server on your local machine
2. Import the sql file under Database -> import_csv.sql
3. DataSource.php -> under class Datasource change the following base on your configuration:
   *  const HOST = '****'; 
   * const USERNAME = '****';
   * const PASSWORD = '****';
   * const DATABASENAME = 'import_csv';
4. Run the application using google chrome
    i. Import the CSV file under TEMPLATE, choose covid_19_data.csv since this contains the whole record.
    ii. Wait for moment... about 1min since there are 15,000 records to be inserted
    iii. A confirmation message will display once import is successfully finished.
    iv. Enter the Date and Max Result
    v. Displays the record for your validation 
*record is GROUP BY country and displays highest to lowest based on confirmed cases from a given date.


