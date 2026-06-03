Blood Bank Management System - Final Version

Default admin login:
Username: admin
Password: admin123
Security answers: red, busan, momo

Setup:
1. Put the bloodbank_final folder inside XAMPP htdocs.
2. Start Apache and MySQL from XAMPP.
3. Open phpMyAdmin.
4. Import bloodbank.sql.
5. Open this in browser:
   http://localhost/bloodbank_final/

Main features:
- Admin login/logout
- Change admin username and password
- Donor CRUD
- Receiver CRUD
- Blood stock update
- User registration/login/logout
- User blood request submission
- Admin approve/cancel blood requests
- Project QR information page

Final fixes included:
- Security-critical include files now use require_once.
- User logout now fully destroys the session.
- Admin approve/cancel request actions now use POST instead of GET.
- Approve request still safely checks stock using transaction and FOR UPDATE.
- Query result checks were added to avoid warnings if a query fails.
- Donor/receiver date validation was added.
- Blood group list is available through blood_groups() helper.
- Donor/receiver list pages show created_at for easier checking.
- Redirect-after-submit pages were fixed so header output does not break redirects.
- PHP syntax checked for every PHP file.

Folder structure:
- includes/ contains config, database connection, auth guards, helpers, headers, and footer.
- donor/ contains donor pages.
- receiver/ contains receiver pages.
- stock/ contains blood stock pages.
- requests/ contains admin and user request pages.
- user/ contains user account pages.
- password/ contains forgot password pages.
- qr/ contains project QR info page.
- css/ contains the main stylesheet.
