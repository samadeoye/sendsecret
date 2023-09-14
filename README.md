# SendSecret
This web application will allow for encoding and decoding of short secret messages.

The sender will type in the message and provide a four-character secret key which will be given to the receiver of the message, alongside a reference code which will be generated upon submission of the message.
The receiver on the other hand, will enter the reference received from the sender as well as the 4-digit secret key, then they get the plain text.

# Installation Guide
- Copy the sendsecret project folder (containing the code file & folders) into your local host or upload on your live environment
- If you do not have a local host, see the Local Host Installation guide at the bottom
- Create a database on any MySQL-supported database management system (DBMS) and name it sendsecret
- Go to the 'includes' folder and copy the database file (sendsecret.sql)
- Run the sql script on the DBMS to import the database and tables
- Open the connect.php file in the 'includes' folder and update the database configuration settings for local/production depending on your environment
- If you are running on local, visit localhost/sendsecret on your browser to run the app
- If running on a live server, visit your live url

# Local Host Installation
- Download XAMPP at https://www.apachefriends.org/download.html
- Follow the installation steps until completion
- After installation, locate the the xampp/htdocs folder in the directory in which you have installed the software
- Unzip the FinalProduct folder, and unzip the sendsecret folder within
- Copy the sendsecret directory which contains the code files & folders and paste into the xampp/htdocs folder