# Terminology

This document describes some of the terms used in relation to Marathon

- **Employee ID**: A unique ID number assigned to each employee.
- **Employee Account**: An account given to employees to allow them to clock in, clock out, and complete other tasks.
- **Admin Account**: An account given to store owners and managers that grants full control to create, delete, and edit any positions, employees, and system configuration settings.
- **Shift Verification Hash**: This is a hash given to an employee after they clock out of a shift that allows them to cryptographically prove to their employer that they worked that shift.
- **Clock In Verification Key**: This is a key set by an admin that is used to generate Shift Verification Hashes. This key is kept private from employees to prevent them from being able to generate fake Shift Verification Hashes.
