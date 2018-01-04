###############################################################################
#
# Authors: Joseph Gonzales, Abhi Koukutla, Stephen Maddux
# Date Finalized: 2017, December 12
#
###############################################################################

This is the Corpus Christi Chamber of Commerce official website.
The files presented are set up to work in the root directory or the directory
your http daemon and PHP interpreter are set to look in.

______________________________________________________________________________
-DISCLAIMER:
As of December 16, 2017, this project will no longer be maintained by the 
authors listed. This project is presented in an "as is" state, further 
modifications will no longer be representative of the original authors work or
motivations.

______________________________________________________________________________
-BACKGROUND INFORMATION:
This site is designed to display informational data about the local schools,
opportunities, and events being hosted in the Corpus Christi area. Please
contact the United Chamber of Commerce representatives if you would like to
use this site to advertise or inform the general public of an event or any
other information.

______________________________________________________________________________
-HOW TO SET UP THE SITE:
Create an initial database, give it a name that reflects the site. Remember to
change the database name variable in "siteconnect.php" to use the name you
choose.

Next you will need to create 2 users, one with update, index, insert, view,
delete, and select, the other user will only have select and view. Give them
obscured passwords, in order to prevent any data leak. Now add both users to
the database you created. 

In the "siteconnect.php", insert the user with the most rights to the variables
$_SESSION['login_user'] = 'your admin name here';
$_SESSION['login_password'] = 'your admin password here';

and put the user with only the select right into the function labeled 'connectDB'
$user = 'your basic user name here';
$psword = 'your basic user psword here';

The set of files and folders given to you will need to be put into the database, 
except the database files with the extension ".sql". The ".sql" files will be 
instead used to create tables and default entries for your website. 
To do this, navigate to your host computer, or in this case the godaddy 
account. Then click on the program "phpMYadmin", which will then give you 
options to create and import your own database file.

Select the import button, then select the "database.sql" file and import this
file.

This will then create various tables in the database program, so now the data,
such as text, links, and dates, can be stored in those newly created tables. 
After that there will need to be three accounts created. This section may
require someone with knowledge in SQL to do it, but it should be fairly 
painless.

Click on the "Privileges" link, the "Add new user" link, name this user
"root", with the password as anything you choose, remember to write that down.
Give the new "root" account the access to all of the new tables, with Add,
Edit, Delete, Query, and Show. Click the submit to sumbit these changes.
Click on the "Add new user" again, only this time call this account "Admin",
then give it any password you want. Give it the same rights as "root".

Lastly, Add another user, give them the name "user", and a simple password.
This time, only allow "user" to query from all the tables EXCEPT "login".
This will prevent the user from accessing the login table. Now you have to
set the user to ONLY BE ALLOWED TO QUERY AND SHOW, NOTHING ELSE.

Now to add a username, password and email address so that the admin can login
to the website and being modifying it. Navigate to the table "login", then
select the "Insert" link near the top. Here you will see fields for inputing
your user name, password, and email address. Add them and write them down.
Your password will be better suited if you make it long, have special 
characters, or even encrypt the words with an encryption algorithm. This
will better secure your account from attacks. Once you verify and write
the password or hints down on a paper or in your head, click submit.

Next you will need to import the previously created data into the datase, so
that the website can have some data to show people who access the site.

Select the import button, then select the file "data.sql", please note the
difference in name, DO NOT IMPORT THIS FIRST, IMPORT "database.sql" FIRST!

Now the site is ready for the public to use.

______________________________________________________________________________
-HOW TO USE THE SITE:
The file named index.php is the file that will first load when someone 
accesses the website, from here the webpage will display information that
the user will initially see. 

In order to login and create your own entry on the website, you will have to 
access the admin login page. There are two ways to do this.

Click on the Admin login link at the bottom of the webpage to enter into the
admin login page.

or

Enter 'domain name here'/adminLogin.php into the URL bar

From here you can enter your login credentials, username and password, then
click the submit button. Once authorized, you will have access to the 
administrator tools such as adding new entries, editing entries, and deleting
entries. Coming back to this page and clicking the adminlogout link or 
exiting out of the tab/browser will automatically log you out.

To use these tools, navigate to any of the table pages that you want to add 
data to by clicking on the links at the top of the page, such as "local 
schools" or "reports and journals". The page will display entries for 
previous data entries, as well as a link to "add to database".

Click on the "add to database" link to enter the new data entry page. This
will add an entry to the page you entered from the top links.

This page will show a form for entering the data you want to show on the 
web page. To do so, add the title or name, enter any additional information
regarding the page you want to add to, and add information or a summary of the
information you want to show the users.

By clicking the browse button, you can add as many files to the page as you 
want. It is ideal to keep all files you want to upload in the same folder.

The hyper links section allows you to enter as many website links as you want.

SEPERATE EACH LINK WITH A  SPACE. ex "http://youtube.com http://facebook.com".
Remember to add http or https headers to the external links.

DO NOT CLICK SUBMIT, until you have finalized your changes.

After sumbitting your data, navigate to the page you added to and you will
see your new entry.
Now you can edit or delete this entry by clicking the "modify" or "delete"
links next to your entry.

To edit the entry click "modify" link.

This will display a similar page to the add page, except the data that you
entered from the add page will show up here. You can modify your entry how 
you want here, then click submit and that new data will update the entry
you want to modify.

To delete an entry, click the "delete" link next to the edit link. 

This WILL REMOVE THE ENTRY FOREVER, but the documents and files that you 
uploaded will not be gone. Navigate to the resource folder with your 
godaddy account, go into the resource folder, go into the table folder 
that contained the entry you deleted, then the folder with all the documents
related to the entry you deleted will be there. You can choose to backup 
those documents and images, or delete it off the server.
 
_________________________________________________________________________
WARNING:
In the event that any user with administrator access quits or leaves, you
or your IT staff will have to manually remove that account from the 
database as soon as that person has declared their leave. Their ability to
continue to access the site will leave the site in jeopardy if those 
login credentials remain on the database.

In the event of a hijack taking place, as in someone with or without 
proper login privileges gains unauthorized access to the website, it is
important that you report the incident to godaddy to cease the website
host from working, and notify law enforcement of the incident. If the 
website is displaying malicious, pornorgraphic, violent, or otherwise
illegal information, contact godaddy and your IT department and report this
incident at once.