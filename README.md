# Attendance Management System for School Staff

A web application to manage student attendance.

This is a proof of concept for attendance management systems that users connected to the same network can use remotely.   

This is only an experiment (for now), so local development environment, not recommended to use outside of testing purposes. If there is a need, changes can be made to make this application production-ready. For that, compatibility, security, performance and optimization need to be prioritized over adding new functionality. Since the groundwork is laid out, the amount of work needed for a production-ready application is minimal.  


## Components  
- ~~QR Scanner~~  
  Does not work, potentially due to untrusted SSL certificates. I wasted hours only to realize browsers block camera requests without SSL certificate.   

- Registration and Login system (made manually - done).  

- Secure login with cryptography.  
  Argon2i(d) support is removed because it does not come compiled with XAMPP's Apache.

- School Staff Dashboard (also made manually - wip).  

- Attendance Interface (also made manually - planned).  

- Automatically time out students (planned).  

## Version updates
Since this is an experimental build, updates can break an existing session. It is recommended to destroy existing containers and setup again (as well as re-reading the README). Use `docker compose down` to do so.

## How to run
> **Note**  
> The working directory should be the root of this project.  
> Please read the instructions properly, as the project needs to work with all the components in place.

* **Requirements**  
  - Docker Engine
  - Docker Compose
  - npm or yarn

* **Install**  
  ```pwsh
  $ basename "$(pwd)"
  # Should output ams2, if not then cd into the cloned repository first.
  $ cd ams2
  ```
  Then install with `npm install` or `yarn`.

* **Build and run**  
  ```pwsh
  $ docker compose up
  ```
  <sup> If rebuilding, use `--build` flag.

* **Open**  
  https://localhost:41062/www
  > **Warning**  
  > It is recommended that you read the **How to setup** section before using the website in order to create required databases.

* **Stop**  
  Use `CTRL-C` or `docker ps` to find the name, and `docker kill <name>`

* **Uninstall**  
  ```pwsh
  $ docker compose down
  ```
  Then, you may remove any unneeded images (or uninstall Docker) and delete the cloned repository.

## How to setup

* **To access phpMyAdmin**  
  https://localhost:41062/phpmyadmin  
  You can set up the database here (which is needed). You can also set up user privileges here as well.

* **Installing needed fonts**  
  The website uses `Roboto` and `FontAwesome` as fonts (and icons).
  You can download and install them automatically by using `install_fonts.sh` in this repository. 

* **To create required databases**  
  ```sql
  USE ams2;

  CREATE TABLE users (
    user_id INT NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    hash VARCHAR(128) NOT NULL,
    -- bcrypt uses 60 characters, but if using Argon2i (usually 96 characters or more) then setting VARCHAR(192) may be sufficient
    salt VARCHAR(64) NOT NULL,
    -- bin2hex(random_bytes(32)) max length is 64 characters
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id)
  ) ENGINE=InnoDB;

  CREATE TABLE students (
    user_id INT NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id),
    FOREIGN KEY (created_by) REFERENCES users(user_id)
  ) ENGINE=InnoDB;

  CREATE TABLE attendances (
    user_id INT NOT NULL,
    time_in_out ENUM('in', 'out') NOT NULL,
    complete_datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_by INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, time_in_out, complete_datetime),
    FOREIGN KEY (user_id) REFERENCES students(user_id),
    FOREIGN KEY (created_by) REFERENCES users(user_id)
  ) ENGINE=InnoDB;

  CREATE TABLE sessions (
    session_id VARCHAR(32) NOT NULL,
    -- default md5 algorithm max length is 32 characters
    user_id INT NOT NULL,
    token VARCHAR(64) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (session_id),
    UNIQUE KEY (token),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
  ) ENGINE=InnoDB;

* **Configuration**  
  You can configure some aspects of this project, including the database used, cryptography hash parameters, and registration ID digit conditions in `config.php`.
