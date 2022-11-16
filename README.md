# Marathon

Version 0.2

An open source, transparent, self hosted employee management tool.


## Webpage

You can find the official Marathon webpage, as well as Marathon downloads at <https://v0lttech.com/marathon.php>.


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

### Fast

Marathon doesn't need JavaScript or other modern web technologies. This means it should be blazing fast, even on outdated systems your business may already have.

### Secure

Marathon encrypts all passwords, ensuring that your login credentials can't be obtained even if someone gains physical access to the server you run Marathon on.

### Accessible

Marathon is designed to be fully accessible to those with visual impairments by making sure the interface works with screen-readers and is easily readable regardless of color blindness.

### Modern

Marathon features a lightweight, modern design, making it easy, intuitive, and visually appealing to use.

### Consistent

Due to it's self-hosted nature, Marathon is extremely reliable and resiliant. It doesn't need any external services, or even an internet connection at all. As long as your business is up and running, Marathon will be there along side it.

### Informative

Marathon provides conveinent, relevant statistics to both employees and managers alike, making it quick and easy to see trends and spot issues.

### Reliable

Marathon is extremely fault tolerant, such that a single error won't cause the system-wide issue. Just because a certain function encountered and error doesn't mean your entire business has to go offline.

### Private

Marathon has unrivaled privacy, and contains absolutely no telemetry of any kind. Marathon gives you the peace of mind that absolutely no critical (or even non-critical data) is being shared with any third parties.

## Bug Reports

Marathon is a very complex system of interconnected databases and modules. While I do my best to ensure Marathon is as stable as possible, I'm a single person developer, and I'm bound to miss things. If you find something wrong with Marathon, whether it be a bug or something that just doesn't work as you'd expect, I'd greatly appreciate if you would make me aware of the issue so I can fix it. Feel free to contact me using the information found at <https://v0lttech.com/contact.php>.
