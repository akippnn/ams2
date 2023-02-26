# Attendance Management System for School Staff

A web application to manage student attendance.

This is a proof of concept for attendance management systems that users connected to the same network can use remotely.   

This is only an experiment (for now), so local development environment, not recommended to use outside of testing purposes. If there is a need, changes can be made to make this application production-ready. For that, compatibility, security, performance and optimization need to be prioritized over adding new functionality. Since the groundwork is laid out, the amount of work needed for a production-ready application is minimal.  


## Components  
- ~~QR Scanner~~  
  Does not work, potentially due to untrusted SSL certificates. I wasted hours only to realize browsers block camera requests without SSL certificate.   

- Registration and Login system (made manually - done).  

- Secure login with cryptography.  
  Argon2i(d) support is removed because it is not compiled normally in XAMPP.

- School Staff Dashboard (also made manually - wip).  

- Attendance Interface (also made manually - planned).  

- Automatically time out students (planned).  

## How to run
> **Note**  
> The working directory should be the root of this project.  
> This is only a README on how to run this project as intended.  

* **Requirements**  
  - Docker Engine
  - Docker Compose
  - npm or yarn

* **Install**  
  While inside the `ams2` repostory, `cd` into the `ams2` app:
  ```pwsh
  $ cd ams2
  ```
  Then install
  ```pwsh
  # npm
  $ npm install
  # yarn
  $ yarn install
  ```

* **Build and run**  
  ```pwsh
  $ docker compose up
  ```
  <sup> If rebuilding, use `--build` flag.

* **Open**  
  > **Warning**  
  > It is recommended that you read the **How to setup** section before using the website.

  http://localhost:41062/www

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

* **To create needed databases**  
  ```sql
  USE ams2;

  CREATE TABLE users (
    user_id INT NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    hash VARCHAR(255) NOT NULL,
    salt VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id)
  ) ENGINE=InnoDB;

  CREATE TABLE students (
    user_id INT NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    created_by INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
    session_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    token VARCHAR(64) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (session_id),
    UNIQUE KEY (token),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
  ) ENGINE=InnoDB;
  ```

* **Configuration**  
  You can configure some aspects of this project, including the database used, cryptography hash parameters, and registration ID digit conditions in `config.php`.
