# Terminology

This document describes some of the terms used in relation to Marathon

- **Employee ID**: A unique ID number assigned to each employee.
- **Employee Account**: An account given to employees to allow them to clock in, clock out, and complete other tasks.
- **Admin Account**: An account given to store owners and managers that grants full control to create, delete, and edit any positions, employees, and system configuration settings.
- **Shift**: A shift is simply a span of time spent on the job. A shift spans from the time an employee started and until they ended a particular session of work.
- **Shift Verification Hash**: This is a hash given to an employee after they clock out of a shift that allows them to cryptographically prove to their employer that they worked that shift.
- **Clock In Verification Key**: This is a key set by an admin that is used to generate Shift Verification Hashes. This key is kept private from employees to prevent them from being able to generate fake Shift Verification Hashes.
- **Unpaid Shift**: An unpaid shift is a shift worked by an employee that has yet to be paid out. After you've paid out a shift, or added it to the employee's weekly pay, you should mark the shift as paid.
- **Employee Dashboard**: The employee dashboard is the first page an employee sees after signing in. It allows them to access all of the tools and pages they might need to use.
- **Main Admin Page**: The main admin page is the first page admins will see after logging it. It allows them to manage employees, positions, and access tools and information they may need.
