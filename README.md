# Marathon

Version 0.2

An open source, transparent, self hosted employee management tool.


## Description

Marathon is an employee tracking tool designed to prioritize both employees and their managers. With Marathon, managers can add employees to the system, manage their information, and track payment information. Employees can quickly and easy clock in, clock out, and keep track of their hours and pay.

Marathon's main defining feature is it's unrivaled transparency. Using simple cryptography, Marathon allows employees to prove that they worked a given shift to their employers using a 'shift verification hash'. Similarly, employers can know with near certainty that if an employee has a shift verification hash that they did indeed work a given shift. Simply put, when an employee clocks out of their shift, they recieve a unique string of seemingly random characters that has been generated using their employer's defined key, and contains all of the information about their shift. Only someone with this key could generate such a string. If a doubt about the hours worked by an employee comes up, the employee can present this random string, and their employer can use their key to see if the information contained in the string matches the hours the employee claims to have worked.


## Features

### Self Hosted

Marathon is run completely on your own hardware, meaning it doesn't have to be dependent on an internet connection. You're free to set up Marathon however is best for your situation.

### Transparent

Marathon is designed to be transparent for employees, allowing them to be sure they are being paid fairly without compromising the privacy or security of other employees. Simiarly, employers can be confident knowing that the software they trust with the business is completely open source and freely auditable.

### Libre

Marathon is completely open source, meaning you're completely free to inspect, audit, and modify the code that powers it.

### Stable

Marathon protects you from yourself by detecting malformatted information before it is added to the database. Even if invalid data does make it through the filters, it will be stored in a safe way that won't corrupt the database after being loaded.

### Convenient

Just as you would expect from an employee management tool, Marathon is designed to make the job of you and your employees as convenient as possible.

### Lightweight

Marathon is lightweight enough to comfortably run on an inexpensive server like a Raspberry Pi. Even if you don't have a device that can run Marathon, you can get one for $30 and be on your way.

### Backwards Compatible

Marathon doesn't need JavaScript or other modern web technologies. This means it should run just fine, even on outdated systems your business may already have.

### Free

Marathon is free both in terms of freedom and cost. Marathon itself costs nothing to use, and since you have the freedom to host it how you want, you also don't have to go through V0LT to set it up!

### Accessibility

Marathon is designed to be fully accessible to those with visual impairments by making sure the interface works with screen-readers and is easily readable regardless of color blindness.

### Secure

Marathon encrypts all passwords, ensuring that your login credentials can't be obtained even if someone gains physical access to the server you run Marathon on.

### Statistics

Marathon allows managers to quickly view their store statistics at a glance. Statistics can help to quickly determine how many unpaid shifts still need to be paid out, and how many people are currently clocked in.


## Bug Reports

Marathon is a very complex system of interconnected databases and modules. While I do my best to ensure Marathon is as stable as possible, I'm a single person developer, and I'm bound to miss things. If you find something wrong with Marathon, whether it be a bug or something that just doesn't work as you'd expect, I'd greatly appreciate if you would make me aware of the issue so I can fix it. Feel free to contact me using the information found at <https://v0lttech.com/contact.php>, or submit a issue on GitHub
